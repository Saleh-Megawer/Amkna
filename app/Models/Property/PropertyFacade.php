<?php
namespace App\Models\Property;

use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Property\Property;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class PropertyFacade extends Model implements TranslatableContract
{

    use Translatable;

    protected $guarded = [];
    public $table   = 'property_facades';

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = ['name'];

    /**
     * Relationship: a facade can have many deals.
     */
    public function deals()
    {
        return $this->hasMany(Deal::class, 'facade_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'facade_id');
    }

    public function by()
    {
        return $this->hasOne(Admin::class, 'id', 'created_by')->select('id', 'full_name');
    }
}
