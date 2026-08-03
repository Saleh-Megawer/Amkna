<?php
namespace App\Models\OwnerAssociation;

use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\OwnerAssociation\OwnerAssociationRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OwnerAssociationRequestReply extends Model
{
    protected $guarded = [];

    // ============================================
    // العلاقات
    // ============================================

    public function request(): BelongsTo
    {
        return $this->belongsTo(OwnerAssociationRequest::class, 'request_id');
    }

    public function replier(): MorphTo
    {
        return $this->morphTo();
    }

    // public function admin()
    // {
    //     return $this->belongsTo(Admin::class, 'replier_id')
    //         ->where('replier_type', Admin::class);
    // }

    // ============================================
    // Accessors - نوع الرد
    // ============================================

    // public function getTypeTextAttribute(): string
    // {
    //     return match($this->type) {
    //         'comment' => 'تعليق',
    //         'update' => 'تحديث',
    //         'status_change' => 'تغيير حالة',
    //         'internal' => 'ملاحظة داخلية',
    //         default => $this->type,
    //     };
    // }

    // public function getTypeClassAttribute(): string
    // {
    //     return match($this->type) {
    //         'comment' => 'badge-primary',
    //         'update' => 'badge-info',
    //         'status_change' => 'badge-warning',
    //         'internal' => 'badge-secondary',
    //         default => 'badge-light',
    //     };
    // }

    // public function getTypeIconAttribute(): string
    // {
    //     return match($this->type) {
    //         'comment' => '💬',
    //         'update' => '📝',
    //         'status_change' => '🔄',
    //         'internal' => '🔒',
    //         default => '📄',
    //     };
    // }

    // ============================================
    // Helper Methods
    // ============================================

    public function isFromClient(): bool
    {
        return $this->replier_type === Client::class;
    }

    public function isFromAdmin(): bool
    {
        return $this->replier_type === Admin::class;
    }

    public function getReplierNameAttribute(): string
    {
        if (! $this->replier) {
            return 'غير محدد';
        }

        // لو Admin
        if ($this->isFromAdmin()) {
            return $this->replier->full_name ?? 'غير محدد';
        }

        // لو Client
        return $this->replier->name ?? 'غير محدد';
    }

    public function getReplierRoleAttribute(): string
    {
        if ($this->isFromClient()) {
            return 'عميل';
        }

        if ($this->isFromAdmin()) {
            return 'موظف';
        }

        return 'غير محدد';
    }

    public function isInternal(): bool
    {
        return $this->is_internal === true || $this->type === 'internal';
    }

    public function canBeDeleted(): bool
    {
        // يمكن حذف التعليقات العادية فقط
        return $this->type === 'comment';
    }

    public function canBeEdited(): bool
    {
        // يمكن تعديل التعليقات العادية فقط وخلال 15 دقيقة
        return $this->type === 'comment' && $this->created_at->addMinutes(15)->isFuture();
    }
}
