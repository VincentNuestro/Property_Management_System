<?php

namespace App\Enums;

enum LeaseStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case EXPIRING = 'expiring';
    case EXPIRED = 'expired';
    case TERMINATED = 'terminated';
    case RENEWED = 'renewed';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::EXPIRING => 'Expiring Soon',
            self::EXPIRED => 'Expired',
            self::TERMINATED => 'Terminated',
            self::RENEWED => 'Renewed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::ACTIVE => 'green',
            self::EXPIRING => 'yellow',
            self::EXPIRED => 'red',
            self::TERMINATED => 'orange',
            self::RENEWED => 'blue',
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
