<?php

namespace App\Enums;

enum InquiryStatus: string
{
    case NEW = 'new';
    case CONTACTED = 'contacted';
    case QUALIFIED = 'qualified';
    case PROPOSAL_SENT = 'proposal_sent';
    case WON = 'won';
    case LOST = 'lost';

    public function label(): string
    {
        return match($this) {
            self::NEW => 'New',
            self::CONTACTED => 'Contacted',
            self::QUALIFIED => 'Qualified',
            self::PROPOSAL_SENT => 'Proposal Sent',
            self::WON => 'Won',
            self::LOST => 'Lost',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::NEW => 'blue',
            self::CONTACTED => 'cyan',
            self::QUALIFIED => 'purple',
            self::PROPOSAL_SENT => 'yellow',
            self::WON => 'green',
            self::LOST => 'red',
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
