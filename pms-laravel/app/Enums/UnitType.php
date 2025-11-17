<?php

namespace App\Enums;

enum UnitType: string
{
    case COMMERCIAL = 'commercial';
    case OFFICE = 'office';
    case RESIDENTIAL = 'residential';
    case PARKING = 'parking';
    case STORAGE = 'storage';
    case KIOSK = 'kiosk';

    public function label(): string
    {
        return match($this) {
            self::COMMERCIAL => 'Commercial',
            self::OFFICE => 'Office',
            self::RESIDENTIAL => 'Residential',
            self::PARKING => 'Parking',
            self::STORAGE => 'Storage',
            self::KIOSK => 'Kiosk',
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
