<?php

namespace App\Models\Dashboard\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminAttributes extends Model
{
    use HasFactory;
    public $table = 'admin_attributes';
    public $guarded = [];
    public $timestamps = false;
}
