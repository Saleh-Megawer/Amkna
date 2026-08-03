<?php

namespace App\Models\Dashboard;

use App\Models\Dashboard\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MailReply extends Model
{

    use HasFactory;
    public $table = 'mail_replies';
    public $guarded = [];


    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'reply_by');
    }

}
