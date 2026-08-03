<?php
namespace App\Models\OwnerAssociation;

use App\Models\Dashboard\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OwnerAssociationPoll extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($poll) {
            if (empty($poll->uuid)) {
                $poll->uuid = (string) Str::uuid();
            }
        });
    }

    // العلاقات
    public function ownerAssociation()
    {
        return $this->belongsTo(OwnerAssociation::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function votes()
    {
        return $this->hasMany(OwnerAssociationPollVote::class, 'poll_id');
    }

    // تحقق إذا عميل معين صوّت
    public function hasVoted($clientId)
    {
        return $this->votes()->where('client_id', $clientId)->exists();
    }

    // إحصائيات
    public function yesVotesCount()
    {
        return $this->votes()->where('vote', 'yes')->count();
    }

    public function noVotesCount()
    {
        return $this->votes()->where('vote', 'no')->count();
    }

    public function totalVotesCount()
    {
        return $this->votes()->count();
    }
}
