<?php
namespace App\Models\Dashboard\Crm\Client;

use App\Models\Dashboard\Admin\Admin;
use Illuminate\Database\Eloquent\Model;

class ClientNote extends Model
{
    public $guarded = [];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
