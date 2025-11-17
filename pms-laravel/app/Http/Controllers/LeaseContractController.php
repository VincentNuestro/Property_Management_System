<?php

namespace App\Http\Controllers;

use App\Models\LeaseContract;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\ContractCharge;
use App\Http\Requests\StoreLeaseContractRequest;
use App\Http\Requests\UpdateLeaseContractRequest;
use App\Enums\LeaseStatus;
use App\Enums\BillingCycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaseContractController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(LeaseContract::class, 'lease_contract');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LeaseContract::with(['property', 'tenant', 'units']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by property
        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        // Filter by tenant
        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        // Filter expiring soon (within 30 days)
        if ($request->boolean('expiring_soon')) {
            $query->expiringWithin(30);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'contract_number');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $leaseContracts = $query->paginate(15);

        // Get filter data
        $properties = Property::select('id', 'name')->orderBy('name')->get();
        $tenants = Tenant::select('id', 'first_name', 'last_name')->orderBy('last_name')->get();

        return view('lease-contracts.index', [
            'leaseContracts' => $leaseContracts,
            'properties' => $properties,
            'tenants' => $tenants,
            'statuses' => LeaseStatus::options(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $properties = Property::select('id', 'code', 'name')->where('status', 'active')->orderBy('name')->get();
        $tenants = Tenant::select('id', 'first_name', 'last_name', 'email')
            ->where('status', 'active')
            ->orderBy('last_name')
            ->get();

        // Pre-select property and units if provided
        $selectedPropertyId = $request->get('property_id');
        $selectedUnits = [];

        if ($selectedPropertyId) {
            $selectedUnits = Unit::where('property_id', $selectedPropertyId)
                ->where('status', 'available')
                ->select('id', 'unit_code', 'unit_number')
                ->orderBy('unit_code')
                ->get();
        }

        return view('lease-contracts.create', [
            'properties' => $properties,
            'tenants' => $tenants,
            'billingCycles' => BillingCycle::options(),
            'selectedPropertyId' => $selectedPropertyId,
            'selectedUnits' => $selectedUnits,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeaseContractRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            // Generate contract number if not provided
            if (empty($data['contract_number'])) {
                $data['contract_number'] = $this->generateContractNumber();
            }

            // Create the lease contract
            $leaseContract = LeaseContract::create($data);

            // Attach units with their rent and dues
            if (isset($data['units']) && is_array($data['units'])) {
                foreach ($data['units'] as $unitData) {
                    $leaseContract->units()->attach($unitData['unit_id'], [
                        'monthly_rent' => $unitData['monthly_rent'] ?? 0,
                        'association_dues' => $unitData['association_dues'] ?? 0,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('lease-contracts.show', $leaseContract)
                ->with('success', 'Lease contract created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create lease contract: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaseContract $leaseContract)
    {
        $leaseContract->load([
            'property',
            'tenant',
            'units',
            'contractCharges',
            'invoices.payments'
        ]);

        // Calculate financial summary
        $financialSummary = [
            'total_monthly_rent' => $leaseContract->total_monthly_rent,
            'total_association_dues' => $leaseContract->total_association_dues,
            'total_monthly_charges' => $leaseContract->total_monthly_charges,
            'security_deposit' => $leaseContract->security_deposit,
            'advance_rent_months' => $leaseContract->advance_rent_months,
            'total_invoiced' => $leaseContract->invoices->sum('total_amount'),
            'total_paid' => $leaseContract->invoices->sum('paid_amount'),
            'total_balance' => $leaseContract->invoices->sum('balance_amount'),
        ];

        return view('lease-contracts.show', [
            'leaseContract' => $leaseContract,
            'financialSummary' => $financialSummary,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaseContract $leaseContract)
    {
        // Only allow editing DRAFT contracts
        if ($leaseContract->status !== LeaseStatus::DRAFT) {
            return back()->with('error', 'Only draft contracts can be edited.');
        }

        $leaseContract->load(['units']);

        $properties = Property::select('id', 'code', 'name')->where('status', 'active')->orderBy('name')->get();
        $tenants = Tenant::select('id', 'first_name', 'last_name', 'email')
            ->where('status', 'active')
            ->orderBy('last_name')
            ->get();

        $availableUnits = Unit::where('property_id', $leaseContract->property_id)
            ->where(function($query) use ($leaseContract) {
                $query->where('status', 'available')
                    ->orWhereHas('leaseContracts', function($q) use ($leaseContract) {
                        $q->where('lease_contract_id', $leaseContract->id);
                    });
            })
            ->select('id', 'unit_code', 'unit_number')
            ->orderBy('unit_code')
            ->get();

        return view('lease-contracts.edit', [
            'leaseContract' => $leaseContract,
            'properties' => $properties,
            'tenants' => $tenants,
            'billingCycles' => BillingCycle::options(),
            'availableUnits' => $availableUnits,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeaseContractRequest $request, LeaseContract $leaseContract)
    {
        // Only allow updating DRAFT contracts
        if ($leaseContract->status !== LeaseStatus::DRAFT) {
            return back()->with('error', 'Only draft contracts can be updated.');
        }

        DB::beginTransaction();
        try {
            $data = $request->validated();

            $leaseContract->update($data);

            // Update units with their rent and dues
            if (isset($data['units']) && is_array($data['units'])) {
                $syncData = [];
                foreach ($data['units'] as $unitData) {
                    $syncData[$unitData['unit_id']] = [
                        'monthly_rent' => $unitData['monthly_rent'] ?? 0,
                        'association_dues' => $unitData['association_dues'] ?? 0,
                    ];
                }
                $leaseContract->units()->sync($syncData);
            }

            DB::commit();

            return redirect()
                ->route('lease-contracts.show', $leaseContract)
                ->with('success', 'Lease contract updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to update lease contract: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaseContract $leaseContract)
    {
        // Only allow deleting DRAFT contracts
        if ($leaseContract->status !== LeaseStatus::DRAFT) {
            return back()->with('error', 'Only draft contracts can be deleted.');
        }

        $leaseContract->delete();

        return redirect()
            ->route('lease-contracts.index')
            ->with('success', 'Lease contract deleted successfully.');
    }

    /**
     * Activate a draft contract
     */
    public function activate(Request $request, LeaseContract $leaseContract)
    {
        $this->authorize('update', $leaseContract);

        if ($leaseContract->status !== LeaseStatus::DRAFT) {
            return back()->with('error', 'Only draft contracts can be activated.');
        }

        if ($leaseContract->units()->count() === 0) {
            return back()->with('error', 'Cannot activate contract without units.');
        }

        $leaseContract->update(['status' => LeaseStatus::ACTIVE]);

        return back()->with('success', 'Lease contract activated successfully.');
    }

    /**
     * Terminate an active contract
     */
    public function terminate(Request $request, LeaseContract $leaseContract)
    {
        $this->authorize('update', $leaseContract);

        if ($leaseContract->status !== LeaseStatus::ACTIVE) {
            return back()->with('error', 'Only active contracts can be terminated.');
        }

        $request->validate([
            'terminated_date' => ['required', 'date'],
            'termination_reason' => ['required', 'string', 'max:1000'],
        ]);

        $leaseContract->update([
            'status' => LeaseStatus::TERMINATED,
            'terminated_date' => $request->terminated_date,
            'termination_reason' => $request->termination_reason,
        ]);

        return back()->with('success', 'Lease contract terminated successfully.');
    }

    /**
     * Create a renewal contract from existing contract
     */
    public function renew(Request $request, LeaseContract $leaseContract)
    {
        $this->authorize('create', LeaseContract::class);

        if (!in_array($leaseContract->status, [LeaseStatus::ACTIVE, LeaseStatus::EXPIRED])) {
            return back()->with('error', 'Only active or expired contracts can be renewed.');
        }

        $request->validate([
            'start_date' => ['required', 'date', 'after:' . $leaseContract->end_date],
            'end_date' => ['required', 'date', 'after:start_date'],
            'escalation_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        DB::beginTransaction();
        try {
            // Create new contract
            $newContract = $leaseContract->replicate();
            $newContract->contract_number = $this->generateContractNumber();
            $newContract->start_date = $request->start_date;
            $newContract->end_date = $request->end_date;
            $newContract->status = LeaseStatus::DRAFT;
            $newContract->terminated_date = null;
            $newContract->termination_reason = null;

            // Apply escalation if provided
            if ($request->filled('escalation_rate')) {
                $escalationMultiplier = 1 + ($request->escalation_rate / 100);
            }

            $newContract->save();

            // Copy units with escalated rent
            foreach ($leaseContract->units as $unit) {
                $monthlyRent = $unit->pivot->monthly_rent;
                $associationDues = $unit->pivot->association_dues;

                if (isset($escalationMultiplier)) {
                    $monthlyRent = round($monthlyRent * $escalationMultiplier, 2);
                    $associationDues = round($associationDues * $escalationMultiplier, 2);
                }

                $newContract->units()->attach($unit->id, [
                    'monthly_rent' => $monthlyRent,
                    'association_dues' => $associationDues,
                ]);
            }

            // Update old contract status
            $leaseContract->update(['status' => LeaseStatus::RENEWED]);

            DB::commit();

            return redirect()
                ->route('lease-contracts.show', $newContract)
                ->with('success', 'Renewal contract created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create renewal contract: ' . $e->getMessage());
        }
    }

    /**
     * Download contract as PDF
     */
    public function downloadContract(LeaseContract $leaseContract)
    {
        $this->authorize('view', $leaseContract);

        // TODO: Implement PDF generation
        return back()->with('info', 'PDF download feature coming soon.');
    }

    /**
     * Add charge to contract
     */
    public function addCharge(Request $request, LeaseContract $leaseContract)
    {
        $this->authorize('update', $leaseContract);

        $request->validate([
            'charge_type_id' => ['required', 'exists:charge_types,id'],
            'description' => ['nullable', 'string', 'max:500'],
            'amount' => ['required', 'numeric', 'min:0'],
            'is_recurring' => ['boolean'],
            'effective_date' => ['required', 'date'],
        ]);

        $leaseContract->contractCharges()->create([
            'charge_type_id' => $request->charge_type_id,
            'description' => $request->description,
            'amount' => $request->amount,
            'is_recurring' => $request->boolean('is_recurring'),
            'effective_date' => $request->effective_date,
        ]);

        return back()->with('success', 'Charge added successfully.');
    }

    /**
     * Get available units for a property (AJAX)
     */
    public function getAvailableUnits(Request $request)
    {
        $propertyId = $request->get('property_id');

        if (!$propertyId) {
            return response()->json([]);
        }

        $units = Unit::where('property_id', $propertyId)
            ->where('status', 'available')
            ->select('id', 'unit_code', 'unit_number', 'monthly_rent_amount')
            ->orderBy('unit_code')
            ->get();

        return response()->json($units);
    }

    /**
     * Generate a unique contract number
     */
    private function generateContractNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        $prefix = "LC-{$year}{$month}";

        $lastContract = LeaseContract::where('contract_number', 'like', "{$prefix}%")
            ->orderBy('contract_number', 'desc')
            ->first();

        if ($lastContract) {
            $lastNumber = (int) substr($lastContract->contract_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "{$prefix}-{$newNumber}";
    }
}
