<?php

namespace App\Enums\Deal;

enum DealFollowUpPriority: string
{
    case LOW = 'low';
    case NORMAL = 'normal';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::LOW => 'منخفضة',
            self::NORMAL => 'عادية',
            self::HIGH => 'عالية',
            self::URGENT => 'عاجلة',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::LOW => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 15l6 6l6 -6"></path></svg>',
            
            self::NORMAL => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l14 0"></path></svg>',
            
            self::HIGH => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 -6l6 6"></path></svg>',
            
            self::URGENT => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 -6l6 6"></path><path d="M6 15l6 -6l6 6"></path></svg>',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::LOW => 'badge-secondary',
            self::NORMAL => 'badge-info',
            self::HIGH => 'badge-warning',
            self::URGENT => 'badge-danger',
        };
    }
}
