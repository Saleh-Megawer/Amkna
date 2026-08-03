<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityTranslation extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    public $table      = 'cities_translations';

}
