<?php
namespace App\Models\About;

use Illuminate\Database\Eloquent\Model;

class AboutTranslation extends Model
{
    public $timestamps = false;
    protected $guarded = [];

  
    protected $casts = [
        'our_journey' => 'array',
    ];
}
