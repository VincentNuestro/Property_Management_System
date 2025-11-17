<?php

namespace App\Enums;

enum TenantType: string
{
    case INDIVIDUAL = 'individual';
    case CORPORATE = 'corporate';

    public function label(): string
    {
        return match($this) {
            self::INDIVIDUAL => 'Individual',
            self::CORPORATE => 'Corporate',
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
