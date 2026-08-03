<?php
namespace App\Enums\Rental;

use App\Enums\Traits\HasEnums;

enum CommissionStatus: string {
    use HasEnums;

    case PENDING   = 'pending';
    case COLLECTED = 'collected';

    public function label(): string
    {
        return match ($this) {
            self::PENDING   => 'قيد الانتظار',
            self::COLLECTED => 'محصل',
        };
    }

       public static function fromLog($value): string
    {
        return self::tryFrom($value)?->label() ?? $value;
    }

    
    public function badge(): string
    {
        return match ($this) {
            self::PENDING   => 'badge badge-warning',
            self::COLLECTED => 'badge badge-success',
        };
    }
}
