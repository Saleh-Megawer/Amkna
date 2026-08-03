<?php
namespace App\Models\Dashboard\Rental;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Rental\PaymentScheduleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Dashboard\Financial\FinancialTransaction;

class RentalPaymentSchedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'due_date' => 'date',
        'paid_at'  => 'datetime',
        'status'   => PaymentScheduleStatus::class,
    ];

    protected $table = 'rental_payment_schedules';

    public function getResolvedStatusAttribute(): PaymentScheduleStatus
    {
        if (
            $this->status === PaymentScheduleStatus::PENDING &&
            $this->due_date < now()->toDateString()
        ) {
            return PaymentScheduleStatus::OVERDUE;
        }

        return $this->status;
    }

    public function getDueDateFormattedAttribute()
    {
        return Carbon::parse($this->due_date)->format('Y-m-d');
    }
    
// public function rentalContract()
// {
//     return $this->belongsTo(RentalContract::class, 'rental_contract_id', 'id');
// }

    // Relationships

    public function rentalContract()
    {
        return $this->belongsTo(RentalContract::class);
    }

    public function transaction()
    {
        return $this->belongsTo(FinancialTransaction::class, 'payment_reference');
    }

    // Helper Methods

    public function isOverdue()
    {
        return $this->status->value === 'pending' && $this->due_date < now();
    }
}
