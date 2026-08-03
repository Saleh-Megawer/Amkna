<?php
namespace App\Models\Dashboard\Crm\Deal;

use App\Models\City;
use App\Helpers\Response;
use Illuminate\Support\Str;
use App\Models\Neighborhood;
use App\Models\Dashboard\Tag;
use App\Enums\Deal\DealPurpose;
use App\Models\Dashboard\Source;
use App\Models\Dashboard\Status;
use App\Models\Property\Property;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Property\PropertyType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Crm\Client\Client;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        // 'id',
        'neighborhoods',
    ];

    protected $casts = [
        'purpose'    => DealPurpose::class,
        'is_won'     => 'boolean',
        'is_lost'    => 'boolean',
        'amount'     => 'decimal:2',
        'commission' => 'decimal:2',
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
        $row = $this->where('uuid', $value)->first();

        if (! $row) {

            // If request expects JSON (API / AJAX)
            if (request()->expectsJson()) {
                abort(Response::error('الصفقة غير موجودة أو الرابط غير صحيح', ['style' => 'toastr']));

            }

            // Else return Laravel's normal 404 page
            abort(404);
        }

        return $row;
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function neighborhoods()
    {
        return $this->belongsToMany(Neighborhood::class, 'deal_neighborhoods');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'deal_tag', 'deal_id', 'tag_id');
    }

    public function properties()
    {
        return $this->belongsToMany(
            Property::class,
            'deal_property', // اسم الجدول الوسيط
            'deal_id',       // foreign key في الجدول الوسيط للـ Deal
            'property_id'    // foreign key في الجدول الوسيط للـ Property
        );
    }

    // public function status()
    // {
    //     return $this->belongsTo(Status::class, 'status_id');
    // }

    public function assignedTo()
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function chats()
    {
        return $this->hasMany(DealChat::class)->orderByDesc('contacted_at');
    }

    public function attachments()
    {
        return $this->hasMany(DealAttachment::class)->orderByDesc('created_at');
    }

    public function followUps()
    {
        return $this->hasMany(DealFollowUp::class)->orderBy('scheduled_at');
    }

    /////////////////////////////
    // public function getPurposeTextAttribute(): string
    // {
    //     return $this->purpose === 'buy'
    //         ? __('deal.purpose.buy')
    //         : __('deal.purpose.rent');
    // }

    // public function getResultTextAttribute(): string
    // {
    //     return $this->is_won
    //         ? __('deal.result.won')
    //         : __('deal.result.in_progress');
    // }

    // public function getStatusTextAttribute(): string
    // {
    //     return $this->status?->name ?? __('deal.status.pending');
    // }

    // public function getStatusClassAttribute(): string
    // {
    //     return match (true) {
    //         $this->is_won => 'badge-success',
    //         default       => 'badge-info',
    //     };
    // }



}
