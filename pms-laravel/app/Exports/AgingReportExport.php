<?php

namespace App\Exports;

use App\Models\Invoice;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AgingReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $asOfDate = !empty($this->filters['as_of_date'])
            ? Carbon::parse($this->filters['as_of_date'])
            : now();

        $query = Invoice::query()
            ->with([
                'property:id,name,code',
                'tenant:id,first_name,last_name,middle_name,company_id',
                'tenant.company:id,name',
            ])
            ->unpaid()
            ->where('due_date', '<=', $asOfDate);

        if (!empty($this->filters['property_id'])) {
            $query->where('property_id', $this->filters['property_id']);
        }

        if (!empty($this->filters['tenant_id'])) {
            $query->where('tenant_id', $this->filters['tenant_id']);
        }

        $invoices = $query->get();

        // Group by tenant and calculate aging buckets
        $data = collect();

        foreach ($invoices->groupBy('tenant_id') as $tenantId => $tenantInvoices) {
            $tenant = $tenantInvoices->first()->tenant;
            $tenantName = $tenant->company
                ? $tenant->company->name
                : $tenant->first_name . ' ' . $tenant->last_name;

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
                } elseif ($daysOverdue <= 30) {
                    $buckets['1-30'] += $balance;
                } elseif ($daysOverdue <= 60) {
                    $buckets['31-60'] += $balance;
                } elseif ($daysOverdue <= 90) {
                    $buckets['61-90'] += $balance;
                } else {
                    $buckets['90+'] += $balance;
                }
            }

            $data->push([
                'tenant_name' => $tenantName,
                'current' => $buckets['current'],
                '1-30' => $buckets['1-30'],
                '31-60' => $buckets['31-60'],
                '61-90' => $buckets['61-90'],
                '90+' => $buckets['90+'],
                'total' => array_sum($buckets),
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Tenant',
            'Current',
            '1-30 Days',
            '31-60 Days',
            '61-90 Days',
            '90+ Days',
            'Total',
        ];
    }

    public function map($row): array
    {
        $currencySymbol = config('pms.currency.symbol', '₱');

        return [
            $row['tenant_name'],
            $currencySymbol . number_format($row['current'], 2),
            $currencySymbol . number_format($row['1-30'], 2),
            $currencySymbol . number_format($row['31-60'], 2),
            $currencySymbol . number_format($row['61-90'], 2),
            $currencySymbol . number_format($row['90+'], 2),
            $currencySymbol . number_format($row['total'], 2),
        ];
    }

    public function title(): string
    {
        return 'Aging Report';
    }
}
