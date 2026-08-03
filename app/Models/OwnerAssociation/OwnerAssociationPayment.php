<?php

namespace App\Models\OwnerAssociation;

use App\Models\Dashboard\Admin\Admin;
use App\Models\OwnerAssociation\OwnerAssociationRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class OwnerAssociationPayment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'paid_amount'       => 'decimal:2',
        'subscription_from' => 'date',
        'subscription_to'   => 'date',
        'verified_at'       => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    // ==================
    // العلاقات
    // ==================

    public function request(): BelongsTo
    {
        return $this->belongsTo(OwnerAssociationRequest::class, 'request_id');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'verified_by');
    }

    // ==================
    // Helpers
    // ==================

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'  => 'قيد المراجعة',
            'verified' => 'تم التحقق',
            'rejected' => 'مرفوض',
            default    => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'  => 'warning',
            'verified' => 'success',
            'rejected' => 'danger',
            default    => 'secondary',
        };
    }
}
