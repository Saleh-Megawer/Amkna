<?php
namespace App\Models\Dashboard\Admin;

use App\Models\Dashboard\Rental\RentalContract;
use App\Models\Interest;
use App\Services\AdminLastSeenUpdater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public $table       = 'admins';
    public $timestamps  = false;
    protected $fillable = [

        // Personal Data
        'id',
        'f_name',
        'l_name',
        'full_name',
        'email',
        'password',
        'phone',
        'about',
        'country',
        'city',
        'zip_code',
        'skills',
        'job',

        // Media
        'avatar',
        'cover',

        // Dashboard Settings For This Admin
        'language',
        'theme',

        // Other
        'last_seen',
        'email_verified_at',
        'status',
        'joining_date',
        'joining_date',
        'type',
        'is_available',
        'marketing_license',
        'is_marketer_request',
    ];

    public function scopeExcludeSystem($query)
    {
        return $query->where('id', '!=', 1);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_seen' => 'datetime',
    ];

    public function getIsOnlineAttribute(): bool
    {
        return $this->last_seen !== null
            && $this->last_seen->greaterThan(now()->subMinutes(AdminLastSeenUpdater::ONLINE_MINUTES));
    }

    public function getLastSeenLabelAttribute(): string
    {
        if (! $this->last_seen) {
            return 'لم يظهر بعد';
        }

        if ($this->is_online) {
            return 'متصل الآن';
        }

        return 'آخر ظهور '.$this->last_seen->diffForHumans();
    }

    public function rentalContracts()
    {
        return $this->hasMany(RentalContract::class);
    }

    public function assignedInterests()
    {
        return $this->hasMany(Interest::class, 'assigned_to');
    }

    public function scopeTypeSales($query, $column = 'type', $value = 'sales')
    {
        return $query->where($column, $value);
    }

    public function getIsSalesAttribute()
    {
        return $this->type === 'sales';
    }
    // public function getIsSalesAttribute()
    // {
    //     return $this->type === 'sales';
    // }

    public function scopeIsActive($query)
    {
        return $query->where('status', '1');
    }

    public function scopeIsAvailable($query)
    {
        return $query->where('is_available', 1);
    }
}
