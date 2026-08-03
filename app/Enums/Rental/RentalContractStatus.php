<?php
namespace App\Enums\Rental;

use App\Enums\Traits\HasEnums;

enum RentalContractStatus: string {
    use HasEnums;

    case DRAFT      = 'draft';
    case ACTIVE     = 'active';
    case EXPIRED    = 'expired';
    case TERMINATED = 'terminated';
    case CANCELLED  = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT      => 'مسودة',
            self::ACTIVE     => 'عقد نشط',
            self::EXPIRED    => 'منتهي',
            self::TERMINATED => 'مفسوخ',
            self::CANCELLED  => 'ملغى',
        };
    }

    public static function options(): array
    {
        return [
            [
                'id'   => self::DRAFT->value,
                'name' => 'مسودة',
            ],
            [
                'id'   => self::ACTIVE->value,
                'name' => 'عقد نشط',
            ],
            [
                'id'   => self::EXPIRED->value,
                'name' => 'منتهي',
            ],
            [
                'id'   => self::TERMINATED->value,
                'name' => 'مفسوخ',
            ],
            [
                'id'   => self::CANCELLED->value,
                'name' => 'ملغي',
            ],
        ];
    }

    public static function fromLog($value): string
    {
        return self::tryFrom($value)?->label() ?? $value;
    }

    public function badge(): string
    {
        return match ($this) {
            self::DRAFT      => 'badge badge-secondary',
            self::ACTIVE     => 'badge badge-success',
            self::EXPIRED    => 'badge badge-warning',
            self::TERMINATED => 'badge badge-danger',
            self::CANCELLED  => 'badge badge-dark',
        };
    }

}
