<?php
namespace App\Models\Dashboard\Crm\Deal;

use App\Enums\Deal\DealChatContactType;
use App\Enums\Deal\DealChatOutcome;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Deal\Deal;
use Illuminate\Database\Eloquent\Model;

class DealChat extends Model
{
    protected $fillable = [
        'deal_id',
        'contact_type',
        'contacted_at',
        'duration',
        'notes',
        'outcome',
        'next_action',
        'created_by',
    ];

    protected $casts = [
        'contact_type' => DealChatContactType::class,
        'outcome'      => DealChatOutcome::class,
        'contacted_at' => 'datetime',
        'duration'     => 'integer',
    ];

    // Relationships
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
