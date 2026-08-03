<?php
namespace App\Enums\Property;

use App\Enums\Traits\HasEnums;

enum PropertyAvailabilityStatus: string {
    use HasEnums;

    case AVAILABLE = 'available';
    case RESERVED  = 'reserved';
    case RENTED    = 'rented';
    case SOLD      = 'sold';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'متاح',
            self::RESERVED  => 'محجوز',
            self::RENTED    => 'مأجر',
            self::SOLD      => 'مباع',
        };
    }

    public function mainCardLabel(): string
    {
        return match (app()->getLocale()) {

            'ar'    => match ($this) {
                self::AVAILABLE => 'متاح الآن',
                self::RESERVED  => 'محجوز',
                self::RENTED    => 'مؤجَّر حاليًا',
                self::SOLD      => 'تم البيع',
            },

            default => match ($this) {
                self::AVAILABLE => 'Available Now',
                self::RESERVED  => 'Reserved',
                self::RENTED    => 'Rented',
                self::SOLD      => 'Sold Out',
            },
        };
    }

    public static function options(): array
    {
        return [
            [
                'id'   => self::AVAILABLE->value,
                'name' => 'متاح',
            ],
            [
                'id'   => self::RESERVED->value,
                'name' => 'محجوز',
            ],
            [
                'id'   => self::RENTED->value,
                'name' => 'مأجر',
            ],
            [
                'id'   => self::SOLD->value,
                'name' => 'مباع',
            ],
        ];
    }

    public function badge(): string
    {
        return match ($this) {
            self::AVAILABLE => 'badge badge-light',
            self::RESERVED  => 'badge badge-warning',
            self::RENTED    => 'badge badge-info',
            self::SOLD      => 'badge badge-danger',
        };
    }
}
