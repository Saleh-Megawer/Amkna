<?php
namespace App\Models;

use App\Models\City;
use App\Models\Dashboard\Admin\Admin;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name', 'desc'];

    public $guarded = [];
    public $table   = 'neighborhoods';

    // public function products()
    // {
    //     return $this->hasMany(Products::class, 'neighborhood', 'id');
    // }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function by()
    {
        return $this->hasOne(Admin::class, 'id', 'created_by')->select('id', 'full_name');
    }

    public function deals()
    {
        return $this->belongsToMany(Deal::class, 'deal_neighborhoods');
    }

}
