<?php
namespace App\Models\OwnerAssociation;

use App\Enums\OwnerAssociation\RequestPriority;
use App\Enums\OwnerAssociation\RequestStatus;
use App\Enums\OwnerAssociation\RequestType;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class OwnerAssociationRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'reviewed_at'  => 'datetime',
        'completed_at' => 'datetime',
        'closed_at'    => 'datetime',
        'priority'     => RequestPriority::class,
        'type'         => RequestType::class,
        'status'       => RequestStatus::class,

    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('uuid', $value)->firstOrFail();
    }

    // ============================================
    // العلاقات
    // ============================================

    public function ownerAssociation(): BelongsTo
    {
        return $this->belongsTo(OwnerAssociation::class, 'owner_association_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(OwnerAssociationUnit::class, 'unit_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }
    public function assignedTo()
    {
        return $this->assignedAdmin();
    }

    // في OwnerAssociationRequest Model
    public function attachments(): HasMany
    {
        return $this->hasMany(OwnerAssociationRequestAttachment::class, 'owner_association_request_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(OwnerAssociationRequestReply::class, 'request_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(OwnerAssociationPayment::class, 'request_id');
    }

    // Helper
    public function isPaymentRequest(): bool
    {
        return $this->type == RequestType::SUBSCRIPTION_PAYMENT;
    }

    // // ============================================
    // // Accessors - نوع الطلب
    // // ============================================

    // public function getTypeTextAttribute(): string
    // {
    //     return match ($this->type) {
    //         'report'      => 'بلاغ',
    //         'complaint'   => 'شكوى',
    //         'maintenance' => 'صيانة',
    //         'service'     => 'طلب خدمة',
    //         'suggestion'  => 'اقتراح',
    //         'inquiry'     => 'استفسار',
    //         'emergency'   => 'طارئ',
    //         'general'     => 'عام',
    //         default       => $this->type,
    //     };
    // }

    // public function getTypeClassAttribute(): string
    // {
    //     return match ($this->type) {
    //         'report'      => 'badge-warning',
    //         'complaint'   => 'badge-danger',
    //         'maintenance' => 'badge-info',
    //         'service'     => 'badge-primary',
    //         'suggestion'  => 'badge-success',
    //         'inquiry'     => 'badge-secondary',
    //         'emergency'   => 'badge-danger',
    //         'general'     => 'badge-light',
    //         default       => 'badge-light',
    //     };
    // }

    // public function getTypeIconAttribute(): string
    // {
    //     return match ($this->type) {
    //         'report'      => '⚠️',
    //         'complaint'   => '😠',
    //         'maintenance' => '🔧',
    //         'service'     => '🛎️',
    //         'suggestion'  => '💡',
    //         'inquiry'     => '❓',
    //         'emergency'   => '🚨',
    //         'general'     => '📋',
    //         default       => '📄',
    //     };
    // }

    // // ============================================
    // // Accessors - الحالة
    // // ============================================

    // public function getStatusTextAttribute(): string
    // {
    //     return match ($this->status) {
    //         'pending'      => 'قيد الانتظار',
    //         'under_review' => 'قيد المراجعة',
    //         'in_progress'  => 'قيد التنفيذ',
    //         'completed'    => 'مكتمل',
    //         'closed'       => 'مغلق',
    //         'rejected'     => 'مرفوض',
    //         'cancelled'    => 'ملغي',
    //         default        => $this->status,
    //     };
    // }

    // public function getStatusClassAttribute(): string
    // {
    //     return match ($this->status) {
    //         'pending'      => 'badge-warning',
    //         'under_review' => 'badge-info',
    //         'in_progress'  => 'badge-primary',
    //         'completed'    => 'badge-success',
    //         'closed'       => 'badge-secondary',
    //         'rejected'     => 'badge-danger',
    //         'cancelled'    => 'badge-dark',
    //         default        => 'badge-light',
    //     };
    // }

    // public function getStatusIconAttribute(): string
    // {
    //     return match ($this->status) {
    //         'pending'      => '⏳',
    //         'under_review' => '👀',
    //         'in_progress'  => '⚙️',
    //         'completed'    => '✅',
    //         'closed'       => '🔒',
    //         'rejected'     => '❌',
    //         'cancelled'    => '🚫',
    //         default        => '📋',
    //     };
    // }

    // // ============================================
    // // Accessors - الأولوية
    // // ============================================

    // public function getPriorityTextAttribute(): string
    // {
    //     return match ($this->priority) {
    //         'low'    => 'منخفضة',
    //         'medium' => 'متوسطة',
    //         'high'   => 'عالية',
    //         'urgent' => 'عاجلة',
    //         default  => $this->priority,
    //     };
    // }

    // public function getPriorityClassAttribute(): string
    // {
    //     return match ($this->priority) {
    //         'low'    => 'badge-secondary',
    //         'medium' => 'badge-info',
    //         'high'   => 'badge-warning',
    //         'urgent' => 'badge-danger',
    //         default  => 'badge-light',
    //     };
    // }

    // public function getPriorityIconAttribute(): string
    // {
    //     return match ($this->priority) {
    //         'low'    => '🔵',
    //         'medium' => '🟡',
    //         'high'   => '🟠',
    //         'urgent' => '🔴',
    //         default  => '⚪',
    //     };
    // }

    // // ============================================
    // // Helper Methods
    // // ============================================

    public function isOpen(): bool
    {
        return in_array($this->status, ['pending', 'under_review', 'in_progress']);
    }

    public function isClosed(): bool
    {
        return in_array($this->status, ['completed', 'closed', 'rejected', 'cancelled']);
    }

    // public function canBeEdited(): bool
    // {
    //     return $this->status === 'pending';
    // }

    // public function canBeCancelled(): bool
    // {
    //     return $this->status === 'pending';
    // }

    // public function isEmergency(): bool
    // {
    //     return $this->type === 'emergency' || $this->priority === 'urgent';
    // }

    // public function hasAttachments(): bool
    // {
    //     return $this->attachments()->exists();
    // }

    // public function getRepliesCountAttribute(): int
    // {
    //     return $this->replies()->where('is_internal', false)->count();
    // }
}
