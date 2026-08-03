<?php
namespace App\Enums\Financial;

use App\Enums\Traits\HasEnums;

enum PaymentMethod: string {
    use HasEnums;

    case CASH          = 'cash';
    case BANK_TRANSFER = 'bank_transfer';
    case CHECK         = 'check';
    case CARD          = 'card';

    public function label(): string
    {
        return match ($this) {
            self::CASH          => 'نقدي',
            self::BANK_TRANSFER => 'تحويل بنكي',
            self::CHECK         => 'شيك',
            self::CARD          => 'بطاقة',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::CASH          => 'badge badge-success',
            self::BANK_TRANSFER => 'badge badge-primary',
            self::CHECK         => 'badge badge-info',
            self::CARD          => 'badge badge-warning',
        };
    }
}
