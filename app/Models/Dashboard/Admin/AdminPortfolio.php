<?php

namespace App\Models\Dashboard\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPortfolio extends Model
{
    use HasFactory;
    public $table = 'admin_portfolios';
    public $guarded = [];
    public $timestamps = false;
}
