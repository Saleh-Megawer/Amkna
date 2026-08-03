<?php
namespace App\Models\OwnerAssociation;

use App\Helpers\Response;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Property\PropertyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OwnerAssociation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function resolveRouteBinding($value, $field = null)
    {
        $row = $this->where('uuid', $value)->first();

        if (! $row) {

            // If request expects JSON (API / AJAX)
            if (request()->expectsJson()) {
                abort(Response::error('ملف اتحاد الملاك المطلوبة غير متاحة في النظام', ['style' => 'toastr']));
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

    public function requests()
    {
        return $this->hasMany(OwnerAssociationRequest::class, 'owner_association_id');
    }

    public function polls()
    {
        return $this->hasMany(OwnerAssociationPoll::class, 'owner_association_id');
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function manager()
    {
        return $this->belongsTo(Client::class, 'manager_client_id');
    }

    public function units()
    {
        return $this->hasMany(OwnerAssociationUnit::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }


}
