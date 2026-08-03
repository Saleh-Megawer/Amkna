<?php
namespace App\Enums\Rental;

use App\Enums\Traits\HasEnums;

enum PaymentFrequency: string {
    use HasEnums;

    case DAILY   = 'daily';
    case MONTHLY = 'monthly';
    case YEARLY  = 'yearly';

    public function label(): string
    {
        return match ($this) {
            self::DAILY   => 'يومي',
            self::MONTHLY => 'شهري',
            self::YEARLY  => 'سنوي',
        };
    }

    public static function fromLog($value): string
    {
        return self::tryFrom($value)?->label() ?? $value;
    }

 
    public static function options(): array
    {
        return [
            [
                'id'   => self::DAILY,
                'name' => 'يومي',
            ],
            [
                'id'   => self::MONTHLY,
                'name' => 'شهري',
            ],
            [
                'id'   => self::YEARLY,
                'name' => 'سنوي',
            ],
        ];
    }

    public function badge(): string
    {
        return match ($this) {
            self::DAILY   => 'badge badge-info',
            self::MONTHLY => 'badge badge-primary',
            self::YEARLY  => 'badge badge-success',
        };
    }
}
