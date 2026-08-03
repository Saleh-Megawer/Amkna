<?php
namespace App\Models;

use App\Models\Property\Property;
use App\Models\Dashboard\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $table       = 'property_statuses';

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

}
