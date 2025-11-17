<?php

namespace App\Enums;

enum UnitStatus: string
{
    case VACANT = 'vacant';
    case OCCUPIED = 'occupied';
    case RESERVED = 'reserved';
    case MAINTENANCE = 'maintenance';
    case UNAVAILABLE = 'unavailable';

    public function label(): string
    {
        return match($this) {
            self::VACANT => 'Vacant',
            self::OCCUPIED => 'Occupied',
            self::RESERVED => 'Reserved',
            self::MAINTENANCE => 'Under Maintenance',
            self::UNAVAILABLE => 'Unavailable',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::VACANT => 'green',
            self::OCCUPIED => 'blue',
            self::RESERVED => 'yellow',
            self::MAINTENANCE => 'orange',
            self::UNAVAILABLE => 'red',
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
