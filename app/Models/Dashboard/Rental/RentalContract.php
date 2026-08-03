<?php
namespace App\Models\Dashboard\Rental;

use App\Enums\Rental\CommissionStatus;
use App\Enums\Rental\DepositStatus;
use App\Enums\Rental\PaymentFrequency;
use App\Enums\Rental\RentalContractStatus;
use App\Helpers\Response;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Financial\FinancialTransaction;
use App\Models\Property\Property;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RentalContract extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'start_date'              => 'date',
        'end_date'                => 'date',
        'deposit_paid_at'         => 'datetime',
        'commission_collected_at' => 'datetime',
        'closure_date'            => 'date',
        'status'                  => RentalContractStatus::class,
        'payment_frequency'       => PaymentFrequency::class,
        'deposit_status'          => DepositStatus::class,
        'commission_status'       => CommissionStatus::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'start_date',
                'end_date',
                'total_rent_amount',
                'payment_frequency',
                'expected_payment_amount',
                'property_id',
                'owner_client_id',
                'tenant_client_id',
                'deposit_amount',
                'deposit_status',
                'commission_amount',
                'commission_status',
                'status',
                'notes',
            ])
            ->logOnlyDirty()        // يسجل التغيير فقط
            ->dontSubmitEmptyLogs() // ما يسجلش لو مفيش تغيير
            ->useLogName('rental_contract');
    }

    public static function logFieldLabel(string $field): string
    {
        return match ($field) {

            'start_date'              => 'تاريخ بداية العقد',
            'end_date'                => 'تاريخ نهاية العقد',

            'total_rent_amount'       => 'إجمالي قيمة الإيجار',
            'expected_payment_amount' => 'قيمة الدفعة الواحدة',

            'payment_frequency'       => 'دورية الدفع',

            'property_id'             => 'العقار المرتبط',

            'owner_client_id'         => 'المالك',
            'tenant_client_id'        => 'المستأجر',

            'deposit_amount'          => 'مبلغ التأمين',
            'deposit_status'          => 'حالة التأمين',

            'commission_amount'       => 'مبلغ العمولة',
            'commission_status'       => 'حالة العمولة',

            'status'                  => 'حالة العقد',

            'notes'                   => 'ملاحظات العقد',

            default                   => ucfirst(str_replace('_', ' ', $field)),
        };
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $row = $this->where('uuid', $value)->first();

        if (! $row) {

            // If request expects JSON (API / AJAX)
            if (request()->expectsJson()) {
                abort(Response::error('العقد غير موجود أو الرابط غير صحيح', ['style' => 'toastr']));
            }
            // Else return Laravel's normal 404 page
            abort(404);
        }

        return $row;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contract) {
            // Generate UUID
            $contract->uuid = Str::uuid();

            // Generate Contract Number
            $year = date('Y');

            $lastContract = self::whereYear('created_at', $year)
                ->orderBy('id', 'desc')
                ->first();

            $sequence = $lastContract ? ($lastContract->id + 1) : 1;

            $contract->contract_number = 'RC-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
        });
    }

    public function getStartDateFormattedAttribute()
    {
        return Carbon::parse($this->start_date)->format('Y-m-d');
    }

    public function getEndDateFormattedAttribute()
    {
        return Carbon::parse($this->end_date)->format('Y-m-d');
    }

    // Relationships

    public function propertyDetail()
    {
        return $this->hasOne(RentalPropertyDetail::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function propertyDetails()
    {
        return $this->hasOne(RentalPropertyDetail::class);
    }

    public function owner()
    {
        return $this->belongsTo(Client::class, 'owner_client_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Client::class, 'tenant_client_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function paymentSchedules()
    {
        return $this->hasMany(RentalPaymentSchedule::class, 'rental_contract_id', 'id');
    }

    public function transactions()
    {
        return $this->morphMany(FinancialTransaction::class, 'transactionable');
    }

    public function attachments()
    {
        return $this->hasMany(RentalContractAttachment::class);
    }

    // Helper Methods

    public function totalCollected()
    {
        return $this->paymentSchedules()
            ->where('status', 'paid')
            ->sum('amount');
    }

    public function totalRemaining()
    {
        return $this->paymentSchedules()
            ->where('status', 'pending')
            ->sum('amount');
    }

    public function totalOverdue()
    {
        return $this->paymentSchedules()
            ->where('status', 'pending')
            ->where('due_date', '<', now())
            ->sum('amount');
    }
}
