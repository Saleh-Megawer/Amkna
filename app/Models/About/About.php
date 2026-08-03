<?php

namespace App\Models\About;

use App\Models\Dashboard\Admin\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class About extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['title','about', 'mission', 'vision'];
    protected $guarded = [];
}
