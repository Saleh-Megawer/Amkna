<?php

namespace App\Models\Dashboard;

use App\Models\Ips;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
    use HasFactory;
    public $table = 'mailbox';
    public $guarded = [];



    public function get()
    {
        return $this->hasOne(Emails::class, 'id', 'from');
    }


    public function ip()
    {
        return $this->hasOne(Ips::class, 'mail_id', 'id')->select(['mail_id', 'ip', 'id', 'status']);
    }

    // public function replies()
    // {
    //     return $this->hasMany(MailReply::class, 'mail', 'id');
    // }



}
