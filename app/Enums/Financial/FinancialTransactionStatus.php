<?php
namespace App\Enums\Financial;

use App\Enums\Traits\HasEnums;

enum FinancialTransactionStatus: string {
    use HasEnums;

    case PENDING   = 'pending';
    case PAID      = 'paid';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING   => 'معلق',
            self::PAID      => 'مدفوع',
            self::CANCELLED => 'ملغي',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENDING   => 'badge badge-warning',
            self::PAID      => 'badge badge-success',
            self::CANCELLED => 'badge badge-danger',
        };
    }
}
