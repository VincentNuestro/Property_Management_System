<?php

namespace App\Enums;

enum PropertyType: string
{
    case MALL = 'mall';
    case OFFICE_BUILDING = 'office_building';
    case RESIDENTIAL = 'residential';
    case MIXED_USE = 'mixed_use';
    case INDUSTRIAL = 'industrial';

    public function label(): string
    {
        return match($this) {
            self::MALL => 'Shopping Mall',
            self::OFFICE_BUILDING => 'Office Building',
            self::RESIDENTIAL => 'Residential Complex',
            self::MIXED_USE => 'Mixed Use',
            self::INDUSTRIAL => 'Industrial Park',
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
