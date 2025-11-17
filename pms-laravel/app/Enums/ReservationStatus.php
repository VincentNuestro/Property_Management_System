<?php

namespace App\Enums;

enum ReservationStatus: string
{
    case ACTIVE = 'active';
    case CONVERTED = 'converted';
    case CANCELLED = 'cancelled';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::CONVERTED => 'Converted to Lease',
            self::CANCELLED => 'Cancelled',
            self::EXPIRED => 'Expired',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'green',
            self::CONVERTED => 'blue',
            self::CANCELLED => 'red',
            self::EXPIRED => 'gray',
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
