<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class FinancialSummaryReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $dateFrom = !empty($this->filters['date_from'])
            ? Carbon::parse($this->filters['date_from'])
            : now()->startOfMonth();

        $dateTo = !empty($this->filters['date_to'])
            ? Carbon::parse($this->filters['date_to'])
            : now()->endOfMonth();

        // Current period revenue
        $invoiceQuery = Invoice::query()
            ->whereBetween('invoice_date', [$dateFrom, $dateTo]);

        $paymentQuery = Payment::query()
            ->whereBetween('payment_date', [$dateFrom, $dateTo])
            ->whereIn('status', ['cleared', 'pending']);

        if (!empty($this->filters['property_id'])) {
            $invoiceQuery->where('property_id', $this->filters['property_id']);
            $paymentQuery->where('property_id', $this->filters['property_id']);
        }

        $totalInvoiced = $invoiceQuery->sum('total_amount');
        $totalCollected = $paymentQuery->sum('amount');
        $outstandingBalance = $invoiceQuery->unpaid()->sum(DB::raw('total_amount - amount_paid'));

        // Current period expenses (maintenance costs from work orders)
        $workOrderQuery = WorkOrder::query()
            ->whereBetween('completed_date', [$dateFrom, $dateTo])
            ->whereNotNull('actual_cost');

        if (!empty($this->filters['property_id'])) {
            $workOrderQuery->whereHas('maintenanceRequest', function ($q) {
                $q->where('property_id', $this->filters['property_id']);
            });
        }

        $maintenanceCosts = $workOrderQuery->sum('actual_cost');

        // Calculate NOI
        $netOperatingIncome = $totalCollected - $maintenanceCosts;

        $data = collect([
            [
                'category' => 'Revenue',
                'item' => 'Total Invoiced',
                'amount' => $totalInvoiced,
            ],
            [
                'category' => 'Revenue',
                'item' => 'Total Collected',
                'amount' => $totalCollected,
            ],
            [
                'category' => 'Revenue',
                'item' => 'Outstanding Balance',
                'amount' => $outstandingBalance,
            ],
            [
                'category' => 'Expenses',
                'item' => 'Maintenance Costs',
                'amount' => $maintenanceCosts,
            ],
            [
                'category' => 'Summary',
                'item' => 'Net Operating Income',
                'amount' => $netOperatingIncome,
            ],
        ]);

        return $data;
    }

    public function headings(): array
    {
        return [
            'Category',
            'Item',
            'Amount',
        ];
    }

    public function map($row): array
    {
        $currencySymbol = config('pms.currency.symbol', '₱');

        return [
            $row['category'],
            $row['item'],
            $currencySymbol . number_format($row['amount'], 2),
        ];
    }

    public function title(): string
    {
        return 'Financial Summary';
    }
}
