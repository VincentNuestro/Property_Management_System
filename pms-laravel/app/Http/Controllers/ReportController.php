<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Exports\AgingReportExport;
use App\Exports\CollectionsReportExport;
use App\Exports\FinancialSummaryReportExport;
use App\Exports\OccupancyReportExport;
use App\Exports\RentRollReportExport;
use App\Models\Invoice;
use App\Models\LeaseContract;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Unit;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Reports dashboard listing all available reports
     */
    public function index()
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_VIEW), 403);

        $reports = [
            [
                'name' => 'Occupancy Report',
                'description' => 'Track unit occupancy rates across properties',
                'route' => 'reports.occupancy',
                'permission' => Permission::REPORTS_OCCUPANCY,
                'icon' => 'building',
            ],
            [
                'name' => 'Rent Roll Report',
                'description' => 'View all active leases with rental details',
                'route' => 'reports.rent-roll',
                'permission' => Permission::REPORTS_RENT_ROLL,
                'icon' => 'document-text',
            ],
            [
                'name' => 'Accounts Receivable Aging',
                'description' => 'Analyze outstanding receivables by age buckets',
                'route' => 'reports.aging',
                'permission' => Permission::REPORTS_AGING,
                'icon' => 'clock',
            ],
            [
                'name' => 'Collections Report',
                'description' => 'Track payment collections and efficiency',
                'route' => 'reports.collections',
                'permission' => Permission::REPORTS_COLLECTIONS,
                'icon' => 'currency-dollar',
            ],
            [
                'name' => 'Financial Summary',
                'description' => 'View revenue, expenses, and net operating income',
                'route' => 'reports.financial-summary',
                'permission' => Permission::REPORTS_FINANCIAL,
                'icon' => 'chart-bar',
            ],
        ];

        return view('reports.index', compact('reports'));
    }

    /**
     * Occupancy Report
     */
    public function occupancy(Request $request)
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_OCCUPANCY), 403);

        $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $dateFrom = $request->date_from ? Carbon::parse($request->date_from) : now()->startOfMonth();
        $dateTo = $request->date_to ? Carbon::parse($request->date_to) : now()->endOfMonth();

        $query = Property::query()->active();

        if ($request->filled('property_id')) {
            $query->where('id', $request->property_id);
        }

        $properties = $query->with(['units' => function ($q) {
            $q->select('id', 'property_id', 'unit_code', 'unit_number', 'status', 'type');
        }])->get();

        $occupancyData = [];
        $totalUnits = 0;
        $totalOccupied = 0;
        $totalVacant = 0;

        foreach ($properties as $property) {
            $units = $property->units;
            $occupied = $units->where('status', 'occupied')->count();
            $vacant = $units->where('status', 'vacant')->count();
            $total = $units->count();

            $occupancyData[] = [
                'property' => $property,
                'total_units' => $total,
                'occupied_units' => $occupied,
                'vacant_units' => $vacant,
                'occupancy_percentage' => $total > 0 ? round(($occupied / $total) * 100, 2) : 0,
                'units' => $units,
            ];

            $totalUnits += $total;
            $totalOccupied += $occupied;
            $totalVacant += $vacant;
        }

        $allProperties = Property::active()->get(['id', 'name']);

        return view('reports.occupancy', [
            'occupancyData' => $occupancyData,
            'totalUnits' => $totalUnits,
            'totalOccupied' => $totalOccupied,
            'totalVacant' => $totalVacant,
            'occupancyPercentage' => $totalUnits > 0 ? round(($totalOccupied / $totalUnits) * 100, 2) : 0,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'properties' => $allProperties,
            'selectedProperty' => $request->property_id,
        ]);
    }

    /**
     * Rent Roll Report
     */
    public function rentRoll(Request $request)
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_RENT_ROLL), 403);

        $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'status' => 'nullable|in:active,all',
            'as_of_date' => 'nullable|date',
        ]);

        $status = $request->get('status', 'active');
        $asOfDate = $request->as_of_date ? Carbon::parse($request->as_of_date) : now();

        $query = LeaseContract::query()
            ->with([
                'property:id,name,code',
                'tenant:id,first_name,last_name,middle_name,company_id',
                'tenant.company:id,name',
                'units:id,unit_code,unit_number',
            ]);

        if ($status === 'active') {
            $query->active();
        }

        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        $leases = $query->get();

        $rentRollData = [];
        $grandTotal = 0;

        foreach ($leases as $lease) {
            $monthlyRent = $lease->total_monthly_rent;
            $associationDues = $lease->total_association_dues;
            $totalCharges = $lease->total_monthly_charges;

            $rentRollData[] = [
                'lease' => $lease,
                'monthly_rent' => $monthlyRent,
                'association_dues' => $associationDues,
                'total_charges' => $totalCharges,
            ];

            $grandTotal += $totalCharges;
        }

        $properties = Property::active()->get(['id', 'name']);

        return view('reports.rent-roll', [
            'rentRollData' => $rentRollData,
            'grandTotal' => $grandTotal,
            'asOfDate' => $asOfDate,
            'properties' => $properties,
            'selectedProperty' => $request->property_id,
            'selectedStatus' => $status,
        ]);
    }

    /**
     * Accounts Receivable Aging Report
     */
    public function aging(Request $request)
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_AGING), 403);

        $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'as_of_date' => 'nullable|date',
        ]);

        $asOfDate = $request->as_of_date ? Carbon::parse($request->as_of_date) : now();

        $query = Invoice::query()
            ->with([
                'property:id,name,code',
                'tenant:id,first_name,last_name,middle_name,company_id',
                'tenant.company:id,name',
            ])
            ->unpaid()
            ->where('due_date', '<=', $asOfDate);

        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        $invoices = $query->get();

        // Group by tenant and calculate aging buckets
        $agingData = [];
        $totals = [
            'current' => 0,
            '1-30' => 0,
            '31-60' => 0,
            '61-90' => 0,
            '90+' => 0,
        ];

        foreach ($invoices->groupBy('tenant_id') as $tenantId => $tenantInvoices) {
            $tenant = $tenantInvoices->first()->tenant;
            $buckets = [
                'current' => 0,
                '1-30' => 0,
                '31-60' => 0,
                '61-90' => 0,
                '90+' => 0,
            ];

            foreach ($tenantInvoices as $invoice) {
                $daysOverdue = $asOfDate->diffInDays($invoice->due_date);
                $balance = $invoice->balance;

                if ($daysOverdue <= 0) {
                    $buckets['current'] += $balance;
                    $totals['current'] += $balance;
                } elseif ($daysOverdue <= 30) {
                    $buckets['1-30'] += $balance;
                    $totals['1-30'] += $balance;
                } elseif ($daysOverdue <= 60) {
                    $buckets['31-60'] += $balance;
                    $totals['31-60'] += $balance;
                } elseif ($daysOverdue <= 90) {
                    $buckets['61-90'] += $balance;
                    $totals['61-90'] += $balance;
                } else {
                    $buckets['90+'] += $balance;
                    $totals['90+'] += $balance;
                }
            }

            $agingData[] = [
                'tenant' => $tenant,
                'buckets' => $buckets,
                'total' => array_sum($buckets),
            ];
        }

        $properties = Property::active()->get(['id', 'name']);

        return view('reports.aging', [
            'agingData' => $agingData,
            'totals' => $totals,
            'grandTotal' => array_sum($totals),
            'asOfDate' => $asOfDate,
            'properties' => $properties,
            'selectedProperty' => $request->property_id,
            'selectedTenant' => $request->tenant_id,
        ]);
    }

    /**
     * Collections Report
     */
    public function collections(Request $request)
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_COLLECTIONS), 403);

        $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $dateFrom = $request->date_from ? Carbon::parse($request->date_from) : now()->startOfMonth();
        $dateTo = $request->date_to ? Carbon::parse($request->date_to) : now()->endOfMonth();

        $query = Payment::query()
            ->with([
                'property:id,name,code',
                'tenant:id,first_name,last_name,middle_name,company_id',
                'tenant.company:id,name',
                'paymentApplications.invoice:id,invoice_number',
            ])
            ->whereBetween('payment_date', [$dateFrom, $dateTo])
            ->whereIn('status', ['cleared', 'pending']);

        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        $payments = $query->get();

        // Calculate payment method breakdown
        $methodBreakdown = $payments->groupBy('payment_method')->map(function ($group) {
            return [
                'count' => $group->count(),
                'total' => $group->sum('amount'),
            ];
        });

        // Get total invoiced amount for the period
        $invoiceQuery = Invoice::query()
            ->whereBetween('invoice_date', [$dateFrom, $dateTo]);

        if ($request->filled('property_id')) {
            $invoiceQuery->where('property_id', $request->property_id);
        }

        $totalInvoiced = $invoiceQuery->sum('total_amount');
        $totalCollected = $payments->sum('amount');
        $collectionEfficiency = $totalInvoiced > 0 ? round(($totalCollected / $totalInvoiced) * 100, 2) : 0;

        $properties = Property::active()->get(['id', 'name']);

        return view('reports.collections', [
            'payments' => $payments,
            'methodBreakdown' => $methodBreakdown,
            'totalCollected' => $totalCollected,
            'totalInvoiced' => $totalInvoiced,
            'collectionEfficiency' => $collectionEfficiency,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'properties' => $properties,
            'selectedProperty' => $request->property_id,
        ]);
    }

    /**
     * Financial Summary Report
     */
    public function financialSummary(Request $request)
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_FINANCIAL), 403);

        $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $dateFrom = $request->date_from ? Carbon::parse($request->date_from) : now()->startOfMonth();
        $dateTo = $request->date_to ? Carbon::parse($request->date_to) : now()->endOfMonth();

        // Calculate previous period dates
        $periodDays = $dateFrom->diffInDays($dateTo);
        $prevDateFrom = $dateFrom->copy()->subDays($periodDays + 1);
        $prevDateTo = $dateFrom->copy()->subDay();

        // Current period revenue
        $invoiceQuery = Invoice::query()
            ->whereBetween('invoice_date', [$dateFrom, $dateTo]);

        $paymentQuery = Payment::query()
            ->whereBetween('payment_date', [$dateFrom, $dateTo])
            ->whereIn('status', ['cleared', 'pending']);

        if ($request->filled('property_id')) {
            $invoiceQuery->where('property_id', $request->property_id);
            $paymentQuery->where('property_id', $request->property_id);
        }

        $totalInvoiced = $invoiceQuery->sum('total_amount');
        $totalCollected = $paymentQuery->sum('amount');
        $outstandingBalance = $invoiceQuery->unpaid()->sum(DB::raw('total_amount - amount_paid'));

        // Previous period revenue
        $prevInvoiceQuery = Invoice::query()
            ->whereBetween('invoice_date', [$prevDateFrom, $prevDateTo]);

        $prevPaymentQuery = Payment::query()
            ->whereBetween('payment_date', [$prevDateFrom, $prevDateTo])
            ->whereIn('status', ['cleared', 'pending']);

        if ($request->filled('property_id')) {
            $prevInvoiceQuery->where('property_id', $request->property_id);
            $prevPaymentQuery->where('property_id', $request->property_id);
        }

        $prevTotalInvoiced = $prevInvoiceQuery->sum('total_amount');
        $prevTotalCollected = $prevPaymentQuery->sum('amount');

        // Current period expenses (maintenance costs from work orders)
        $workOrderQuery = WorkOrder::query()
            ->whereBetween('completed_date', [$dateFrom, $dateTo])
            ->whereNotNull('actual_cost');

        if ($request->filled('property_id')) {
            $workOrderQuery->whereHas('maintenanceRequest', function ($q) use ($request) {
                $q->where('property_id', $request->property_id);
            });
        }

        $maintenanceCosts = $workOrderQuery->sum('actual_cost');

        // Previous period expenses
        $prevWorkOrderQuery = WorkOrder::query()
            ->whereBetween('completed_date', [$prevDateFrom, $prevDateTo])
            ->whereNotNull('actual_cost');

        if ($request->filled('property_id')) {
            $prevWorkOrderQuery->whereHas('maintenanceRequest', function ($q) use ($request) {
                $q->where('property_id', $request->property_id);
            });
        }

        $prevMaintenanceCosts = $prevWorkOrderQuery->sum('actual_cost');

        // Calculate NOI
        $netOperatingIncome = $totalCollected - $maintenanceCosts;
        $prevNetOperatingIncome = $prevTotalCollected - $prevMaintenanceCosts;

        // Calculate changes
        $invoicedChange = $prevTotalInvoiced > 0 ? round((($totalInvoiced - $prevTotalInvoiced) / $prevTotalInvoiced) * 100, 2) : 0;
        $collectedChange = $prevTotalCollected > 0 ? round((($totalCollected - $prevTotalCollected) / $prevTotalCollected) * 100, 2) : 0;
        $expensesChange = $prevMaintenanceCosts > 0 ? round((($maintenanceCosts - $prevMaintenanceCosts) / $prevMaintenanceCosts) * 100, 2) : 0;
        $noiChange = $prevNetOperatingIncome > 0 ? round((($netOperatingIncome - $prevNetOperatingIncome) / $prevNetOperatingIncome) * 100, 2) : 0;

        $properties = Property::active()->get(['id', 'name']);

        return view('reports.financial-summary', [
            'totalInvoiced' => $totalInvoiced,
            'totalCollected' => $totalCollected,
            'outstandingBalance' => $outstandingBalance,
            'maintenanceCosts' => $maintenanceCosts,
            'netOperatingIncome' => $netOperatingIncome,
            'prevTotalInvoiced' => $prevTotalInvoiced,
            'prevTotalCollected' => $prevTotalCollected,
            'prevMaintenanceCosts' => $prevMaintenanceCosts,
            'prevNetOperatingIncome' => $prevNetOperatingIncome,
            'invoicedChange' => $invoicedChange,
            'collectedChange' => $collectedChange,
            'expensesChange' => $expensesChange,
            'noiChange' => $noiChange,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'prevDateFrom' => $prevDateFrom,
            'prevDateTo' => $prevDateTo,
            'properties' => $properties,
            'selectedProperty' => $request->property_id,
        ]);
    }

    /**
     * Export Occupancy Report to Excel
     */
    public function exportOccupancy(Request $request)
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_OCCUPANCY), 403);

        $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        return Excel::download(
            new OccupancyReportExport($request->all()),
            'occupancy-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Export Rent Roll Report to Excel
     */
    public function exportRentRoll(Request $request)
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_RENT_ROLL), 403);

        $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'status' => 'nullable|in:active,all',
            'as_of_date' => 'nullable|date',
        ]);

        return Excel::download(
            new RentRollReportExport($request->all()),
            'rent-roll-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Export Aging Report to Excel
     */
    public function exportAging(Request $request)
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_AGING), 403);

        $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'as_of_date' => 'nullable|date',
        ]);

        return Excel::download(
            new AgingReportExport($request->all()),
            'aging-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Export Collections Report to Excel
     */
    public function exportCollections(Request $request)
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_COLLECTIONS), 403);

        $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        return Excel::download(
            new CollectionsReportExport($request->all()),
            'collections-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Export Financial Summary Report to Excel
     */
    public function exportFinancialSummary(Request $request)
    {
        abort_unless(auth()->user()->can(Permission::REPORTS_FINANCIAL), 403);

        $request->validate([
            'property_id' => 'nullable|exists:properties,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        return Excel::download(
            new FinancialSummaryReportExport($request->all()),
            'financial-summary-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
