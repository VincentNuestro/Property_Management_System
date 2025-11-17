<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Company;
use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Enums\TenantType;
use App\Enums\TenantStatus;
use App\Enums\LeaseStatus;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Tenant::class, 'tenant');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tenant::query()->with('company');

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('tenant_type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'first_name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $tenants = $query->paginate(15);

        return view('tenants.index', [
            'tenants' => $tenants,
            'tenantTypes' => TenantType::options(),
            'tenantStatuses' => TenantStatus::options(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.create', [
            'companies' => Company::active()->orderBy('name')->get(),
            'tenantTypes' => TenantType::options(),
            'tenantStatuses' => TenantStatus::options(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenantRequest $request)
    {
        $tenant = Tenant::create($request->validated());

        return redirect()
            ->route('tenants.show', $tenant)
            ->with('success', 'Tenant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        $tenant->load(['company', 'leaseContracts.unit', 'invoices', 'payments']);

        // Get current active leases
        $activeLeases = $tenant->leaseContracts()
            ->where('status', LeaseStatus::ACTIVE)
            ->with('unit.property')
            ->get();

        // Get lease history
        $leaseHistory = $tenant->leaseContracts()
            ->whereNot('status', LeaseStatus::ACTIVE)
            ->with('unit.property')
            ->orderBy('start_date', 'desc')
            ->limit(10)
            ->get();

        // Get recent invoices
        $recentInvoices = $tenant->invoices()
            ->with('leaseContract.unit')
            ->orderBy('invoice_date', 'desc')
            ->limit(10)
            ->get();

        // Get recent payments
        $recentPayments = $tenant->payments()
            ->orderBy('payment_date', 'desc')
            ->limit(10)
            ->get();

        return view('tenants.show', [
            'tenant' => $tenant,
            'activeLeases' => $activeLeases,
            'leaseHistory' => $leaseHistory,
            'recentInvoices' => $recentInvoices,
            'recentPayments' => $recentPayments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', [
            'tenant' => $tenant,
            'companies' => Company::active()->orderBy('name')->get(),
            'tenantTypes' => TenantType::options(),
            'tenantStatuses' => TenantStatus::options(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantRequest $request, Tenant $tenant)
    {
        $tenant->update($request->validated());

        return redirect()
            ->route('tenants.show', $tenant)
            ->with('success', 'Tenant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        // Check if tenant has active leases
        $activeLeases = $tenant->leaseContracts()
            ->where('status', LeaseStatus::ACTIVE)
            ->count();

        if ($activeLeases > 0) {
            return redirect()
                ->route('tenants.show', $tenant)
                ->with('error', 'Cannot delete tenant with active leases.');
        }

        $tenant->delete();

        return redirect()
            ->route('tenants.index')
            ->with('success', 'Tenant deleted successfully.');
    }
}
