<?php

namespace App\Enums;

enum BillingCycle: string
{
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case SEMI_ANNUAL = 'semi_annual';
    case ANNUAL = 'annual';

    public function label(): string
    {
        return match($this) {
            self::MONTHLY => 'Monthly',
            self::QUARTERLY => 'Quarterly',
            self::SEMI_ANNUAL => 'Semi-Annual',
            self::ANNUAL => 'Annual',
        };
    }

    public function months(): int
    {
        return match($this) {
            self::MONTHLY => 1,
            self::QUARTERLY => 3,
            self::SEMI_ANNUAL => 6,
            self::ANNUAL => 12,
        };
    }

    public static function options(): array
    {
        return array_map(
            fn(self $cycle) => ['value' => $cycle->value, 'label' => $cycle->label(), 'months' => $cycle->months()],
            self::cases()
        );
    }
}
