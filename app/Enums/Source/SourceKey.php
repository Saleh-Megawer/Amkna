<?php
namespace App\Enums\Source;

use App\Enums\Traits\HasEnums;

enum SourceKey: string {
    use HasEnums;

    case MANUAL   = 'manual';
    case WEBSITE  = 'website';
    case CAMPAIGN = 'campaign';
    case PROPERTY = 'property';

    public function label(): string
    {
        return match ($this) {
            self::MANUAL   => 'إضافة يدوية',
            self::WEBSITE  => 'من خلال الموقع',
            self::CAMPAIGN => 'حملة إعلانية',
            self::PROPERTY => 'من صفحة عقار',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::MANUAL   => 'primary',
            self::WEBSITE  => 'info',
            self::CAMPAIGN => 'success',
            self::PROPERTY => 'secondary',
        };
    }
}
