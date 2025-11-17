<?php

namespace App\Enums;

enum MaintenancePriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
            self::URGENT => 'Urgent',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::LOW => 'gray',
            self::MEDIUM => 'blue',
            self::HIGH => 'orange',
            self::URGENT => 'red',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn(self $priority) => ['value' => $priority->value, 'label' => $priority->label(), 'color' => $priority->color()],
            self::cases()
        );
    }
}
