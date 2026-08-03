<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    use HasFactory;
    public $table = 'emails';
    public $guarded = [];



    // Get Mailboxs
    public function mails()
    {
        return $this->hasMany(Mailbox::class, 'from', 'id');
    }
}
