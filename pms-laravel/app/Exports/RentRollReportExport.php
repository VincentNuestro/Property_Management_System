<?php

namespace App\Exports;

use App\Models\LeaseContract;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RentRollReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $status = $this->filters['status'] ?? 'active';

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

        if (!empty($this->filters['property_id'])) {
            $query->where('property_id', $this->filters['property_id']);
        }

        $leases = $query->get();

        $data = collect();

        foreach ($leases as $lease) {
            $tenantName = $lease->tenant->company
                ? $lease->tenant->company->name
                : $lease->tenant->first_name . ' ' . $lease->tenant->last_name;

            $units = $lease->units->pluck('unit_number')->implode(', ');

            $data->push([
                'property_name' => $lease->property->name,
                'contract_number' => $lease->contract_number,
                'tenant_name' => $tenantName,
                'units' => $units,
                'start_date' => $lease->start_date->format('Y-m-d'),
                'end_date' => $lease->end_date->format('Y-m-d'),
                'monthly_rent' => $lease->total_monthly_rent,
                'association_dues' => $lease->total_association_dues,
                'total_charges' => $lease->total_monthly_charges,
                'status' => $lease->status->label(),
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Property',
            'Contract #',
            'Tenant',
            'Units',
            'Start Date',
            'End Date',
            'Monthly Rent',
            'Association Dues',
            'Total Charges',
            'Status',
        ];
    }

    public function map($row): array
    {
        $currencySymbol = config('pms.currency.symbol', '₱');

        return [
            $row['property_name'],
            $row['contract_number'],
            $row['tenant_name'],
            $row['units'],
            $row['start_date'],
            $row['end_date'],
            $currencySymbol . number_format($row['monthly_rent'], 2),
            $currencySymbol . number_format($row['association_dues'], 2),
            $currencySymbol . number_format($row['total_charges'], 2),
            $row['status'],
        ];
    }

    public function title(): string
    {
        return 'Rent Roll Report';
    }
}
