<?php

namespace App\Http\Controllers;

use App\Models\LeaseApplication;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\LeaseContract;
use App\Http\Requests\StoreLeaseApplicationRequest;
use App\Http\Requests\UpdateLeaseApplicationRequest;
use App\Enums\LeaseApplicationStatus;
use App\Enums\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaseApplicationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(LeaseApplication::class, 'lease_application');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LeaseApplication::with(['property', 'tenant', 'reviewedBy']);

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
            $query->forProperty($request->property_id);
        }

        // Filter by tenant
        if ($request->filled('tenant_id')) {
            $query->forTenant($request->tenant_id);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'application_date');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $leaseApplications = $query->paginate(15);

        return view('lease-applications.index', [
            'leaseApplications' => $leaseApplications,
            'statuses' => LeaseApplicationStatus::options(),
            'properties' => Property::orderBy('name')->get(),
            'tenants' => Tenant::orderBy('first_name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lease-applications.create', [
            'properties' => Property::where('status', 'active')->orderBy('name')->get(),
            'tenants' => Tenant::active()->orderBy('first_name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeaseApplicationRequest $request)
    {
        $data = $request->validated();

        // Generate application number
        $data['application_number'] = $this->generateApplicationNumber();
        $data['status'] = LeaseApplicationStatus::DRAFT;

        $leaseApplication = LeaseApplication::create($data);

        return redirect()
            ->route('lease-applications.show', $leaseApplication)
            ->with('success', 'Lease application created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaseApplication $leaseApplication)
    {
        $leaseApplication->load(['property', 'tenant', 'reviewedBy']);

        return view('lease-applications.show', [
            'leaseApplication' => $leaseApplication,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaseApplication $leaseApplication)
    {
        // Only allow editing if status is DRAFT or SUBMITTED
        if (!in_array($leaseApplication->status, [LeaseApplicationStatus::DRAFT, LeaseApplicationStatus::SUBMITTED])) {
            return redirect()
                ->route('lease-applications.show', $leaseApplication)
                ->with('error', 'This application cannot be edited in its current status.');
        }

        return view('lease-applications.edit', [
            'leaseApplication' => $leaseApplication,
            'properties' => Property::where('status', 'active')->orderBy('name')->get(),
            'tenants' => Tenant::active()->orderBy('first_name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeaseApplicationRequest $request, LeaseApplication $leaseApplication)
    {
        // Only allow updating if status is DRAFT or SUBMITTED
        if (!in_array($leaseApplication->status, [LeaseApplicationStatus::DRAFT, LeaseApplicationStatus::SUBMITTED])) {
            return redirect()
                ->route('lease-applications.show', $leaseApplication)
                ->with('error', 'This application cannot be updated in its current status.');
        }

        $leaseApplication->update($request->validated());

        return redirect()
            ->route('lease-applications.show', $leaseApplication)
            ->with('success', 'Lease application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaseApplication $leaseApplication)
    {
        // Only allow deletion if status is DRAFT
        if ($leaseApplication->status !== LeaseApplicationStatus::DRAFT) {
            return redirect()
                ->route('lease-applications.index')
                ->with('error', 'Only draft applications can be deleted.');
        }

        $leaseApplication->delete();

        return redirect()
            ->route('lease-applications.index')
            ->with('success', 'Lease application deleted successfully.');
    }

    /**
     * Submit application for review (DRAFT → SUBMITTED)
     */
    public function submit(LeaseApplication $leaseApplication)
    {
        $this->authorize('update', $leaseApplication);

        if ($leaseApplication->status !== LeaseApplicationStatus::DRAFT) {
            return redirect()
                ->route('lease-applications.show', $leaseApplication)
                ->with('error', 'Only draft applications can be submitted.');
        }

        $leaseApplication->update([
            'status' => LeaseApplicationStatus::SUBMITTED,
        ]);

        return redirect()
            ->route('lease-applications.show', $leaseApplication)
            ->with('success', 'Application submitted successfully.');
    }

    /**
     * Review application (SUBMITTED → UNDER_REVIEW)
     */
    public function review(LeaseApplication $leaseApplication)
    {
        if (!auth()->user()->can(Permission::LEASE_APPLICATIONS_REVIEW)) {
            abort(403, 'You do not have permission to review applications.');
        }

        if ($leaseApplication->status !== LeaseApplicationStatus::SUBMITTED) {
            return redirect()
                ->route('lease-applications.show', $leaseApplication)
                ->with('error', 'Only submitted applications can be reviewed.');
        }

        $leaseApplication->update([
            'status' => LeaseApplicationStatus::UNDER_REVIEW,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('lease-applications.show', $leaseApplication)
            ->with('success', 'Application is now under review.');
    }

    /**
     * Approve application (UNDER_REVIEW → APPROVED)
     */
    public function approve(LeaseApplication $leaseApplication)
    {
        if (!auth()->user()->can(Permission::LEASE_APPLICATIONS_APPROVE)) {
            abort(403, 'You do not have permission to approve applications.');
        }

        if ($leaseApplication->status !== LeaseApplicationStatus::UNDER_REVIEW) {
            return redirect()
                ->route('lease-applications.show', $leaseApplication)
                ->with('error', 'Only applications under review can be approved.');
        }

        $leaseApplication->update([
            'status' => LeaseApplicationStatus::APPROVED,
        ]);

        return redirect()
            ->route('lease-applications.show', $leaseApplication)
            ->with('success', 'Application approved successfully.');
    }

    /**
     * Reject application (any → REJECTED)
     */
    public function reject(Request $request, LeaseApplication $leaseApplication)
    {
        if (!auth()->user()->can(Permission::LEASE_APPLICATIONS_APPROVE)) {
            abort(403, 'You do not have permission to reject applications.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $leaseApplication->update([
            'status' => LeaseApplicationStatus::REJECTED,
            'rejection_reason' => $request->rejection_reason,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('lease-applications.show', $leaseApplication)
            ->with('success', 'Application rejected.');
    }

    /**
     * Convert approved application to lease contract
     */
    public function convertToContract(LeaseApplication $leaseApplication)
    {
        if (!auth()->user()->can(Permission::LEASE_CONTRACTS_CREATE)) {
            abort(403, 'You do not have permission to create lease contracts.');
        }

        if ($leaseApplication->status !== LeaseApplicationStatus::APPROVED) {
            return redirect()
                ->route('lease-applications.show', $leaseApplication)
                ->with('error', 'Only approved applications can be converted to contracts.');
        }

        try {
            DB::beginTransaction();

            // Create the lease contract
            $leaseContract = LeaseContract::create([
                'property_id' => $leaseApplication->property_id,
                'tenant_id' => $leaseApplication->tenant_id,
                'lease_application_id' => $leaseApplication->id,
                'start_date' => $leaseApplication->desired_start_date,
                'lease_term' => $leaseApplication->desired_lease_term,
                'status' => 'draft', // Initial contract status
            ]);

            // Mark application as converted (cancelled status used to indicate converted)
            $leaseApplication->update([
                'status' => LeaseApplicationStatus::CANCELLED,
                'notes' => ($leaseApplication->notes ? $leaseApplication->notes . "\n\n" : '') .
                           "Converted to Lease Contract on " . now()->format('Y-m-d H:i:s'),
            ]);

            DB::commit();

            return redirect()
                ->route('lease-contracts.show', $leaseContract)
                ->with('success', 'Application converted to lease contract successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('lease-applications.show', $leaseApplication)
                ->with('error', 'Failed to convert application: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique application number
     */
    private function generateApplicationNumber(): string
    {
        $prefix = 'LA';
        $year = date('Y');
        $month = date('m');

        $lastApplication = LeaseApplication::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastApplication ? (int) substr($lastApplication->application_number, -4) + 1 : 1;

        return sprintf('%s%s%s%04d', $prefix, $year, $month, $sequence);
    }
}
