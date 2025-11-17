<?php

namespace App\Exports;

use App\Models\Payment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class CollectionsReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle
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

        $query = Payment::query()
            ->with([
                'property:id,name,code',
                'tenant:id,first_name,last_name,middle_name,company_id',
                'tenant.company:id,name',
                'paymentApplications.invoice:id,invoice_number',
            ])
            ->whereBetween('payment_date', [$dateFrom, $dateTo])
            ->whereIn('status', ['cleared', 'pending']);

        if (!empty($this->filters['property_id'])) {
            $query->where('property_id', $this->filters['property_id']);
        }

        $payments = $query->get();

        $data = collect();

        foreach ($payments as $payment) {
            $tenantName = $payment->tenant->company
                ? $payment->tenant->company->name
                : $payment->tenant->first_name . ' ' . $payment->tenant->last_name;

            $invoiceNumbers = $payment->paymentApplications
                ->pluck('invoice.invoice_number')
                ->filter()
                ->implode(', ');

            $data->push([
                'payment_date' => $payment->payment_date->format('Y-m-d'),
                'payment_number' => $payment->payment_number,
                'property_name' => $payment->property->name,
                'tenant_name' => $tenantName,
                'amount' => $payment->amount,
                'payment_method' => $payment->payment_method->label(),
                'reference_number' => $payment->reference_number ?? '',
                'invoice_numbers' => $invoiceNumbers,
                'status' => $payment->status->label(),
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Payment #',
            'Property',
            'Tenant',
            'Amount',
            'Method',
            'Reference',
            'Invoice #',
            'Status',
        ];
    }

    public function map($row): array
    {
        $currencySymbol = config('pms.currency.symbol', '₱');

        return [
            $row['payment_date'],
            $row['payment_number'],
            $row['property_name'],
            $row['tenant_name'],
            $currencySymbol . number_format($row['amount'], 2),
            $row['payment_method'],
            $row['reference_number'],
            $row['invoice_numbers'],
            $row['status'],
        ];
    }

    public function title(): string
    {
        return 'Collections Report';
    }
}
