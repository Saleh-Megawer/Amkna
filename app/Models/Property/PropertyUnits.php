<?php
namespace App\Models\Property;

use App\Models\Dashboard\Admin\Admin;
use Illuminate\Database\Eloquent\Model;

class PropertyUnits extends Model
{

    protected $guarded = [];
    public $table      = 'property_units';

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'admin_id')->select('id', 'full_name');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

}
