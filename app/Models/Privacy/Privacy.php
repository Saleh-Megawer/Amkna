<?php
namespace App\Models\Privacy;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privacy extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['desc'];
    protected $guarded           = [];

}
