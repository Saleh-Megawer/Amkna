<?php
namespace App\Enums\Source;

use App\Enums\Traits\HasEnums;

enum SourceType: string {

    use HasEnums;

    case CLIENT   = 'client';
    case PROPERTY = 'property';

    public function label(): string
    {
        return match ($this) {
            self::CLIENT   => 'عميل',
            self::PROPERTY => 'عقار',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CLIENT   => 'primary',
            self::PROPERTY => 'info',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
