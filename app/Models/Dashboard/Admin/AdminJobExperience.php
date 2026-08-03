<?php

namespace App\Models\Dashboard\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminJobExperience extends Model
{
    use HasFactory;
    public $table = 'admin_job_experiences';
    protected $guarded = [];
}
