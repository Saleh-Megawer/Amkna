<?php
namespace App\Models\Dashboard;

use App\Models\Dashboard\Clients\Client;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = [];

    // /*  العلاقة مع العملاء */
    // public function clients()
    // {
    //     return $this->hasMany(Client::class, 'status_id');
    // }
    
}
