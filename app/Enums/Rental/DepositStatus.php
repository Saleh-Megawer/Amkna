<?php
namespace App\Enums\Rental;

use App\Enums\Traits\HasEnums;

enum DepositStatus: string {
    use HasEnums;

    case PENDING  = 'pending';
    case PAID     = 'paid';
    case REFUNDED = 'refunded';
    case DEDUCTED = 'deducted';

    public function label(): string
    {
        return match ($this) {
            self::PENDING  => 'قيد الانتظار',
            self::PAID     => 'مدفوع',
            self::REFUNDED => 'مسترد',
            self::DEDUCTED => 'مخصوم',
        };
    }

    public static function fromLog($value): string
    {
        return self::tryFrom($value)?->label() ?? $value;
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENDING  => 'badge badge-warning',
            self::PAID     => 'badge badge-success',
            self::REFUNDED => 'badge badge-info',
            self::DEDUCTED => 'badge badge-danger',
        };
    }
}
