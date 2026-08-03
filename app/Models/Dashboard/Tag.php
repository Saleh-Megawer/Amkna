<?php
namespace App\Models\Dashboard;

use App\Models\Dashboard\Clients\Client;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_tag');
    }

}
