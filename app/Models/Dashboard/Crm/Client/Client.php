<?php
namespace App\Models\Dashboard\Crm\Client;

use App\Models\City;
use App\Models\Interest;
use App\Helpers\Response;
use Illuminate\Support\Str;
use App\Models\Neighborhood;
use App\Models\Dashboard\Tag;
use App\Enums\Source\SourceKey;
use App\Models\Dashboard\Source;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Deal\Deal;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Dashboard\Rental\RentalContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Models\OwnerAssociation\OwnerAssociationUnit;
use App\Notifications\ClientResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, LogsActivity, Notifiable, CanResetPassword;

    protected $guard = 'client';

    /**
     * إرسال إشعار إعادة تعيين كلمة المرور
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ClientResetPasswordNotification($token));
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'phone', 'email', 'status_id', 'assigned_to']) // الحقول التي تتابعها
            ->logOnlyDirty()                                                  // سجّل فقط التعديلات
            ->useLogName('client');                                           // يظهر في الlogs
    }

    protected static $logAttributes = ['name', 'phone', 'email', 'status_id', 'assigned_to'];

    protected static $logOnlyDirty = true; // يسجل الحقول اللي اتغيرت بس

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logName = 'client'; // يظهر في الlogs

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen'         => 'datetime',
    ];

    public $table = 'clients';

    ///////////
    public $guarded = [];

    public function resolveRouteBinding($value, $field = null)
    {
        $row = $this->where('uuid', $value)->first();

        if (! $row) {

            // If request expects JSON (API / AJAX)
            if (request()->expectsJson()) {
                abort(Response::error('العميل غير موجود أو الرابط غير صحيح', ['style' => 'toastr']));

            }

            // Else return Laravel's normal 404 page
            abort(404);
        }

        return $row;
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    public function ownedContracts()
    {
        return $this->hasMany(RentalContract::class, 'owner_client_id');
    }

    public function tenantContracts()
    {
        return $this->hasMany(RentalContract::class, 'tenant_client_id');
    }

    /*  علاقة المصدر (Source) */
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id')->where('type', 'client');
    }

    /*  علاقة الوسوم (Tags) - Many to Many */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'client_tag');
    }

    /*  علاقة الشخص المكلّف بالعميل (الموظف) */
    public function assignedAdmin()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    /*  علاقة المدينة */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /*  علاقة الحي */
    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id');
    }

    /*  علاقة الشخص اللي أنشأ السجل */
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class, 'client_id');
    }

    public function notes()
    {
        return $this->hasMany(ClientNote::class, 'client_id');
    }

    public function interests()
    {
        return $this->hasMany(Interest::class);
    }

    public function ownerAssociationUnits()
    {
        return $this->hasMany(OwnerAssociationUnit::class, 'client_id');
    }

    ///////////////////////////////////////////

    /**
     * Build a readable display value for the source.
     * - Returns the source label only for non-manual sources.
     * - For manual sources, append the creator's name when available.
     */
    public function getSourceDisplayAttribute()
    {
        $sourceKey   = $this->source?->key;  // Enum object or null
        $sourceLabel = $sourceKey?->label(); // Label from Enum

        // If NOT manual → return label only
        if ($sourceKey !== SourceKey::MANUAL) {
            return $sourceLabel;
        }

        // If manual → append creator name when exists
        $creatorName = $this->creator?->full_name;

        return $creatorName
            ? "{$sourceLabel} ( {$creatorName} )"
            : $sourceLabel;
    }

    public function isEmailVerified(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    public function hasEmail(): bool
    {
        return ! empty($this->email);
    }

    public function hasAccount(): bool
    {
        return (bool) $this->has_account;
    }

}
