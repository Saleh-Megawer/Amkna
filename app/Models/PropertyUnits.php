<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyUnits extends Model
{
    use HasFactory;
    public $table      = 'property_units';
    protected $guarded = [];
    public $timestamps = false;

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
