<?php

namespace App\Models;

use App\Models\Dashboard\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $table = 'features';

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_feature');
    }

    
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    
}
