<?php

namespace App\Enums;

enum TenantStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case BLACKLISTED = 'blacklisted';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::BLACKLISTED => 'Blacklisted',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'green',
            self::INACTIVE => 'gray',
            self::BLACKLISTED => 'red',
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
