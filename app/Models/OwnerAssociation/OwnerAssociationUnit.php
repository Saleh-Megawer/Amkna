<?php
namespace App\Models\OwnerAssociation;

use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Property\PropertyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerAssociationUnit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ownerAssociation()
    {
        return $this->belongsTo(OwnerAssociation::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
