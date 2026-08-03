<?php
namespace App\Enums\Financial;

use App\Enums\Traits\HasEnums;

enum FinancialTransactionType: string {
    use HasEnums;

    case EXPENSE = 'expense';
    case REVENUE = 'revenue';

    public function label(): string
    {
        return match ($this) {
            self::EXPENSE => 'مصروف',
            self::REVENUE => 'إيراد',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::EXPENSE => 'badge badge-danger',
            self::REVENUE => 'badge badge-success',
        };
    }
}
