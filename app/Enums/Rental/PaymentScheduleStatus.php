<?php
namespace App\Enums\Rental;

use App\Enums\Traits\HasEnums;

enum PaymentScheduleStatus: string {
    use HasEnums;

    case PENDING   = 'pending';
    case PAID      = 'paid';
    case OVERDUE   = 'overdue';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING   => 'قيد الانتظار',
            self::PAID      => 'مدفوع',
            self::OVERDUE   => 'متأخر',
            self::CANCELLED => 'ملغي',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENDING   => 'badge badge-warning',
            self::PAID      => 'badge badge-success',
            self::OVERDUE   => 'badge badge-danger',
            self::CANCELLED => 'badge badge-dark',
        };
    }
}
