<?php

namespace App\Enums;

enum ChargeCategory: string
{
    case RENT = 'rent';
    case UTILITIES = 'utilities';
    case ASSOCIATION_DUES = 'association_dues';
    case PARKING = 'parking';
    case PENALTY = 'penalty';
    case DEPOSIT = 'deposit';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::RENT => 'Rent',
            self::UTILITIES => 'Utilities',
            self::ASSOCIATION_DUES => 'Association Dues',
            self::PARKING => 'Parking',
            self::PENALTY => 'Penalty',
            self::DEPOSIT => 'Deposit',
            self::OTHER => 'Other',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn(self $category) => ['value' => $category->value, 'label' => $category->label()],
            self::cases()
        );
    }
}
