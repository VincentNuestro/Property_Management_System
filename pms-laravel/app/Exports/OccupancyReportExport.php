<?php

namespace App\Exports;

use App\Models\Property;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class OccupancyReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Property::query()->active();

        if (!empty($this->filters['property_id'])) {
            $query->where('id', $this->filters['property_id']);
        }

        $properties = $query->with(['units' => function ($q) {
            $q->select('id', 'property_id', 'unit_code', 'unit_number', 'status', 'type');
        }])->get();

        $data = collect();

        foreach ($properties as $property) {
            $units = $property->units;
            $occupied = $units->where('status', 'occupied')->count();
            $vacant = $units->where('status', 'vacant')->count();
            $total = $units->count();

            $data->push([
                'property_code' => $property->code,
                'property_name' => $property->name,
                'total_units' => $total,
                'occupied_units' => $occupied,
                'vacant_units' => $vacant,
                'occupancy_percentage' => $total > 0 ? round(($occupied / $total) * 100, 2) : 0,
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Property Code',
            'Property Name',
            'Total Units',
            'Occupied Units',
            'Vacant Units',
            'Occupancy %',
        ];
    }

    public function map($row): array
    {
        return [
            $row['property_code'],
            $row['property_name'],
            $row['total_units'],
            $row['occupied_units'],
            $row['vacant_units'],
            $row['occupancy_percentage'] . '%',
        ];
    }

    public function title(): string
    {
        return 'Occupancy Report';
    }
}
