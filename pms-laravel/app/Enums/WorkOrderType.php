<?php

namespace App\Enums;

enum WorkOrderType: string
{
    case PREVENTIVE = 'preventive';
    case CORRECTIVE = 'corrective';
    case EMERGENCY = 'emergency';
    case PROJECT = 'project';

    public function label(): string
    {
        return match($this) {
            self::PREVENTIVE => 'Preventive Maintenance',
            self::CORRECTIVE => 'Corrective Maintenance',
            self::EMERGENCY => 'Emergency',
            self::PROJECT => 'Project',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn(self $type) => ['value' => $type->value, 'label' => $type->label()],
            self::cases()
        );
    }
}
