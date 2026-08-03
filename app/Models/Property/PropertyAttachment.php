<?php
namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAttachment extends Model
{
    use HasFactory;

    // Upload Options For Image
    const PATH      = 'properties/attachments';
    const LARGE     = '1232*753*75';
    const SMALL     = '161*95*75';
    const EXTENSION = 'webp';
    const HASH_NAME = false;

    const MAX_UPLOAD_SIZE  = 52428800; // 50MP
    const MAX_UPLOAD_FILES = 20;
    const ALLOWED_EXT      = "jpeg,jpg,png,webp,bmp,tiff,svg";

    public $table      = 'property_attachments';
    protected $guarded = [];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
