<?php
namespace App\Models\Dashboard\Admin;

use App\Models\Dashboard\Rental\RentalContract;
use App\Models\Interest;
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
