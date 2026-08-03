<?php
namespace App\Models\Property;

use App\Models\Dashboard\Admin\Admin;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model implements TranslatableContract
{

    use Translatable;

    protected $guarded = [];
    public $table   = 'property_amenities';

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = ['name'];

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'created_by')->select('id', 'full_name');
    }

}
