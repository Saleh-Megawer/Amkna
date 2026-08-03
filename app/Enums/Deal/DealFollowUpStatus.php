<?php

namespace App\Enums\Deal;

enum DealFollowUpStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case OVERDUE = 'overdue';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'قيد الانتظار',
            self::COMPLETED => 'تم المتابعة',
            self::CANCELLED => 'المتابعة ملغية',
            self::OVERDUE => 'متابعة متأخرة',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::PENDING => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M12 7v5l3 3"></path></svg>',
            
            self::COMPLETED => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M9 12l2 2l4 -4"></path></svg>',
            
            self::CANCELLED => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M10 10l4 4m0 -4l-4 4"></path></svg>',
            
            self::OVERDUE => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'badge-warning',
            self::COMPLETED => 'badge-success',
            self::CANCELLED => 'badge-secondary',
            self::OVERDUE => 'badge-danger',
        };
    }
}
