<?php

namespace App\Models\OwnerAssociation;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Crm\Client\Client;

class OwnerAssociationPollVote extends Model
{
    protected $guarded = [];

    protected $casts = [
        'vote' => 'string',
    ];

    // العلاقات
    public function poll()
    {
        return $this->belongsTo(OwnerAssociationPoll::class, 'poll_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Helper methods
    public function isYes()
    {
        return $this->vote === 'yes';
    }

    public function isNo()
    {
        return $this->vote === 'no';
    }
}
