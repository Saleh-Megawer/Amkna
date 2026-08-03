<?php
namespace App\Models\Property;

use App\Models\Dashboard\Admin\Admin;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class PropertyFinishingType extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = ['name'];

    protected $guarded = [];

    public $table = 'property_finishing_types';

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
