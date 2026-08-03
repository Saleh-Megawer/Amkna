<?php
namespace App\Models\Dashboard\Crm\Deal;

use App\Enums\Deal\DealFollowUpPriority;
use App\Enums\Deal\DealFollowUpStatus;
use App\Enums\Deal\DealFollowUpType;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Deal\Deal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DealFollowUp extends Model
{
    protected $fillable = [
        'deal_id',
        'follow_up_type',
        'scheduled_at',
        'status',
        'priority',
        'assigned_to',
        'notes',
        'completed_at',
        'created_by',
    ];

    protected $casts = [
        'follow_up_type' => DealFollowUpType::class,
        'status'         => DealFollowUpStatus::class,
        'priority'       => DealFollowUpPriority::class,
        'scheduled_at'   => 'datetime',
        'completed_at'   => 'datetime',
    ];

    // Relationships
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    // Scope for overdue follow-ups
    public function scopeOverdue($query)
    {
        return $query->where('status', DealFollowUpStatus::PENDING->value)
            ->where('scheduled_at', '<', Carbon::now());
    }

    // Scope for pending follow-ups
    public function scopePending($query)
    {
        return $query->where('status', DealFollowUpStatus::PENDING->value);
    }

    // Scope for completed follow-ups
    public function scopeCompleted($query)
    {
        return $query->where('status', DealFollowUpStatus::COMPLETED->value);
    }

    // =====================================
    // Accessor Methods للـ Modal
    // =====================================

    /**
     * 1️⃣ تحقق: هل المتابعة معادها النهارده؟
     */
    public function getIsScheduledTodayAttribute()
    {
        return $this->scheduled_at->isToday();
    }

    /**
     * 2️⃣ تحقق: هل المتابعة لم تتم ومعادها راح (Overdue)؟
     */
    public function getIsOverdueAttribute()
    {
        return $this->status === DealFollowUpStatus::PENDING
        && $this->scheduled_at->isPast();
    }

    public function getIsPendingAttribute()
    {
        return $this->status === DealFollowUpStatus::PENDING;
    }

    /**
     * 3️⃣ حالة المتابعة بشكل نصي (مساعد للـ Modal)
     */
    // public function getStatusTextAttribute()
    // {
    //     if ($this->is_overdue) {
    //         return 'متأخرة';
    //     }

    //     if ($this->is_scheduled_today) {
    //         return 'اليوم';
    //     }

    //     if ($this->scheduled_at->isFuture()) {
    //         return 'قادمة';
    //     }

    //     return $this->status->label();
    // }

    /**
     * 4️⃣ لون Badge حسب الحالة (للـ Modal)
     */
    // public function getStatusBadgeClassAttribute()
    // {
    //     if ($this->is_overdue) {
    //         return 'badge-danger';
    //     }

    //     if ($this->is_scheduled_today) {
    //         return 'badge-info';
    //     }

    //     return $this->status->badgeClass();
    // }

}
