<?php

namespace App\Enums;

enum MaintenanceRequestStatus: string
{
    case SUBMITTED = 'submitted';
    case ACKNOWLEDGED = 'acknowledged';
    case ASSIGNED = 'assigned';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::SUBMITTED => 'Submitted',
            self::ACKNOWLEDGED => 'Acknowledged',
            self::ASSIGNED => 'Assigned',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::SUBMITTED => 'blue',
            self::ACKNOWLEDGED => 'cyan',
            self::ASSIGNED => 'purple',
            self::IN_PROGRESS => 'yellow',
            self::COMPLETED => 'green',
            self::CANCELLED => 'red',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn(self $status) => ['value' => $status->value, 'label' => $status->label(), 'color' => $status->color()],
            self::cases()
        );
    }
}
