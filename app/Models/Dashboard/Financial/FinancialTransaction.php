<?php
namespace App\Models\Dashboard\Financial;

use Illuminate\Support\Str;
use App\Models\Dashboard\Admin\Admin;
use App\Enums\Financial\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Crm\Client\Client;
use App\Enums\Financial\FinancialTransactionType;
use App\Enums\Financial\FinancialTransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'transaction_date' => 'date',
        'type'             => FinancialTransactionType::class,
        'status'           => FinancialTransactionStatus::class,
        'payment_method'   => PaymentMethod::class,
    ];

    // ✅ Auto-generate UUID on create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    // Relationships

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function paidBy()
    {
        return $this->belongsTo(Client::class, 'paid_by');
    }

    public function receivedFrom()
    {
        return $this->belongsTo(Client::class, 'received_from');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
