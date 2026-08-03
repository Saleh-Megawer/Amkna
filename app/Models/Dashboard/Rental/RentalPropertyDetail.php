<?php
namespace App\Models\Dashboard\Rental;

use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Property\PropertyType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentalPropertyDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationships

    public function rentalContract()
    {
        return $this->belongsTo(RentalContract::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }
}
