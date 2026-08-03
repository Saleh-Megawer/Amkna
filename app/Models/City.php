<?php
namespace App\Models;

use App\Models\Dashboard\Admin\Admin;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name', 'desc'];

    public $guarded = [];
    public $table   = 'cities';

    public function by()
    {
        return $this->hasOne(Admin::class, 'id', 'created_by')->select('id', 'full_name');
    }

    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class);
    }

}
