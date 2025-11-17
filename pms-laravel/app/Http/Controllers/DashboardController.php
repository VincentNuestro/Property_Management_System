<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Unit;
use App\Models\LeaseContract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Enums\UnitStatus;
use App\Enums\LeaseStatus;
use App\Enums\InvoiceStatus;
use App\Enums\MaintenanceRequestStatus;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Total Properties (active)
        $totalProperties = Property::active()->count();

        // Unit Statistics
        $totalUnits = Unit::count();
        $occupiedUnits = Unit::occupied()->count();
        $vacantUnits = Unit::vacant()->count();
        $occupancyRate = $totalUnits > 0
            ? round(($occupiedUnits / $totalUnits) * 100, 1)
            : 0;

        // Active Leases
        $activeLeases = LeaseContract::active()->count();

        // Monthly Revenue (sum of active lease rents)
        $monthlyRevenue = LeaseContract::active()
            ->with('units')
            ->get()
            ->sum(function ($lease) {
                return $lease->units->sum('pivot.monthly_rent');
            });

        // Overdue Invoices (count and total amount)
        $overdueInvoices = Invoice::overdue()->get();
        $overdueInvoicesCount = $overdueInvoices->count();
        $overdueInvoicesAmount = $overdueInvoices->sum('balance');

        // Recent Payments (last 5)
        $recentPayments = Payment::with(['tenant', 'property'])
            ->latest('payment_date')
            ->take(5)
            ->get();

        // Expiring Leases (next 30 days)
        $expiringLeases = LeaseContract::expiringWithin(30)
            ->with(['tenant', 'units'])
            ->orderBy('end_date', 'asc')
            ->get();

        // Pending Maintenance Requests
        $pendingMaintenanceCount = MaintenanceRequest::whereIn('status', [
            MaintenanceRequestStatus::OPEN,
            MaintenanceRequestStatus::IN_PROGRESS,
        ])->count();

        return view('dashboard', compact(
            'totalProperties',
            'totalUnits',
            'occupiedUnits',
            'vacantUnits',
            'occupancyRate',
            'activeLeases',
            'monthlyRevenue',
            'overdueInvoicesCount',
            'overdueInvoicesAmount',
            'recentPayments',
            'expiringLeases',
            'pendingMaintenanceCount'
        ));
    }
}
