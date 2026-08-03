<?php
namespace App\Models;

use App\Enums\Interest\InterestStatus;
use App\Enums\Interest\InterestType;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Property\Property;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Interest extends Model
{
    use HasFactory, LogsActivity, Notifiable;

    protected $guarded = [];

    protected $casts = [
        'status'  => InterestStatus::class,
        'type'    => InterestType::class,
        'is_read' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($interest) {
            $interest->uuid = Str::uuid();
        });
    }

    // ========================
    // Activity log
    // ========================
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['assigned_to', 'status'])
            ->logOnlyDirty()
            ->useLogName('interest');
    }
    // ========================
    // Relations
    // ========================

    // Interest belongs to a client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Interest may belong to a property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Assigned admin
    public function assignedAdmin()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }
    public function assignedTo()
    {
        return $this->assignedAdmin();
    }

    public function deal()
    {
        return $this->hasOne(Deal::class, 'interest_id');
    }

    /**
     *
     * Start Filter
     *
     */
    public function scopeFilter($query, array $filters)
    {

        // Status
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        }, function ($query) {
            // ⭐ لو مفيش فلتر status، استبعد المغلقة
            $query->where('status', '!=', 'closed');
        });

        // Assigned To (للـ admin فقط - مش sales)
        $query->when($filters['assigned-to'] ?? null, function ($query, $assignedTo) {
            if ($assignedTo === 'unassigned') {
                $query->whereNull('assigned_to');
            } else {
                $query->where('assigned_to', $assignedTo);
            }
        });

        // Deal Status
        $query->when(isset($filters['has-deal']), function ($query) use ($filters) {
            if ($filters['has-deal'] == '1') {
                $query->has('deal');
            } elseif ($filters['has-deal'] == '0') {
                $query->doesntHave('deal');
            }
        });

        // Read Status
        // $query->when(isset($filters['is-read']), function ($query) use ($filters) {
        //     if ($filters['is-read'] !== '') {
        //         $query->where('is_read', $filters['is-read']);
        //     }
        // });

        // Date Range
        $query->when($filters['date-from'] ?? null, function ($query, $dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        });

        $query->when($filters['date-to'] ?? null, function ($query, $dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        });

        // Search (اسم - جوال - بريد - رقم اهتمام)
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $search = trim($search);

            //  لو القيمة أرقام بس
            if (is_numeric($search)) {

                // ابحث بالـ ID أول حاجة
                $hasResult = Interest::where('id', $search)->exists();

                if ($hasResult) {
                    //  لو لقى نتيجة بالـ ID، ابحث بالـ ID فقط
                    $query->where('id', $search);
                } else {
                    //  لو ملقاش بالـ ID، ابحث بالهاتف
                    $query->whereHas('client', function ($q) use ($search) {
                        $cleanedSearch = ltrim($search, '0');
                        $q->where('phone', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$cleanedSearch}%");
                    });
                }

            } else {
                //  لو القيمة مش أرقام، ابحث بالاسم والبريد
                $query->whereHas('client', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            }
        });

        //  Sort Order
        $sortOrder = $filters['sort-order'] ?? 'desc';
        $query->orderBy('created_at', $sortOrder);

        return $query;
    }

    /**
     *
     *
     * Status
     *
     *
     */
    public function hasDeal(): bool
    {
        return (bool) $this->deal;
    }

    public function canCreateDeal(): bool
    {
        return ! $this->isNotInterested() && ! $this->hasDeal();
    }
    ///////////////
    public function isStatus(InterestStatus $status): bool
    {
        return $this->status === $status;
    }

    public function isClosed(): bool
    {
        return $this->isStatus(InterestStatus::CLOSED);
    }

    public function isConverted(): bool
    {
        return $this->isStatus(InterestStatus::CONVERTED);
    }

    public function isNotInterested(): bool
    {
        return $this->isStatus(InterestStatus::NOT_INTERESTED);
    }

}
