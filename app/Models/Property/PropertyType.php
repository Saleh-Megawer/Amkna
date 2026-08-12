<?php
namespace App\Models\Property;

use App\Models\Dashboard\Admin\Admin;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PropertyType extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name', 'desc'];
    protected $table             = 'property_types';
    protected $guarded           = [];

    protected static function booted()
    {
        // When a property type is created or updated, clear the cached list
        // so it can be rebuilt with fresh data on the next request.
        static::saved(fn() => Cache::forget('property_types_all'));

        // When a property type is deleted, clear the cached list as well.
        static::deleted(fn() => Cache::forget('property_types_all'));
    }

    public function by()
    {
        return $this->hasOne(Admin::class, 'id', 'created_by')->select('id', 'full_name');
    }
}
