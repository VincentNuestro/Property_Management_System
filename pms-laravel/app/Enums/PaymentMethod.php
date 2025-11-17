<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case CHECK = 'check';
    case BANK_TRANSFER = 'bank_transfer';
    case CREDIT_CARD = 'credit_card';
    case ONLINE = 'online';
    case PDC = 'pdc';

    public function label(): string
    {
        return match($this) {
            self::CASH => 'Cash',
            self::CHECK => 'Check',
            self::BANK_TRANSFER => 'Bank Transfer',
            self::CREDIT_CARD => 'Credit Card',
            self::ONLINE => 'Online Payment',
            self::PDC => 'Post-Dated Check',
        };
    }

    public function requiresClearance(): bool
    {
        return match($this) {
            self::CHECK, self::PDC => true,
            default => false,
        };
    }

    public static function options(): array
    {
        return array_map(
            fn(self $method) => [
                'value' => $method->value,
                'label' => $method->label(),
                'requires_clearance' => $method->requiresClearance()
            ],
            self::cases()
        );
    }
}
