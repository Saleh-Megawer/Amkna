<?php
namespace App\Models\Property;

use App\Enums\Property\PropertyAvailabilityStatus;
use App\Enums\Rental\RentalContractStatus;
use App\Models\City;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Dashboard\Crm\Deal\Deal;
use App\Models\Dashboard\Rental\RentalContract;
use App\Models\Interest;
use App\Models\Neighborhood;
use App\Models\Property\PropertyAttachment;
use App\Models\Property\PropertyFacade;
use App\Models\Property\PropertyFinishingType;
use App\Models\Property\PropertyType;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Property extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $guarded = [];

    /**
     * The attributes that are translatable.
     */
    public $translatedAttributes = ['title', 'description'];

    // Upload Options For Image
    const PATH      = 'properties';
    const LARGE     = '1400*1050*75';
    const MEDIUM    = '800*600*75';
    const SMALL     = '400*300*75';
    const EXTENSION = 'webp';
    const HASH_NAME = true;

    protected $casts = [
        'availability_status' => PropertyAvailabilityStatus::class,
    ];

    protected static function booted()
    {
        // Generate UUID on creating
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid     = Str::uuid()->toString();
                $model->admin_id = adminId();
            }
        });

        // Clear filter cache on create/update
        static::saved(function () {
            Cache::forget('property_filter_ranges');
        });

        // Clear filter cache on delete
        static::deleted(function () {
            Cache::forget('property_filter_ranges');
        });
    }

    public function units()
    {
        return $this->hasMany(PropertyUnits::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class)->select('id', 'full_name');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    // public function status() // hash in 2026-01-23
    // {
    //     return $this->belongsTo(PropertyStatus::class, 'property_status_id');
    // }

    public function finishingType()
    {
        return $this->belongsTo(PropertyFinishingType::class, 'property_finishing_type_id');
    }

    public function features()
    {
        return $this->belongsToMany(PropertyFeature::class, 'property_feature');
    }

    public function amenities()
    {
        return $this->belongsToMany(PropertyAmenity::class, 'property_amenity');
    }

    public function attachments()
    {
        return $this->hasMany(PropertyAttachment::class);
    }

    public function interests()
    {
        return $this->hasMany(Interest::class);
    }

    // public function units()
    // {
    //     return $this->hasMany(PropertyUnits::class);
    // }

    public function facade()
    {
        return $this->belongsTo(PropertyFacade::class, 'facade_id');
    }

    // public function scopeFilter($query, $filters = [])
    // {

    //     if (! empty($filters['title'])) {
    //         $normalized = normalizeArabic($filters['title']);

    //         // حول المسافات لكلمة + كلمة للبحث boolean mode
    //         $booleanSearch = str_replace(' ', ' ', $normalized);

    //         $query->whereRaw(
    //             "MATCH(title_normalized_ar, description_normalized_ar) AGAINST(? IN BOOLEAN MODE)",
    //             [$booleanSearch]
    //         );
    //     }

    //     if (! empty($filters['neighborhood_id'])) {
    //         $query->where('neighborhood_id', $filters['neighborhood_id']);
    //     }

    //     if (! empty($filters['property_type_id'])) {
    //         $query->where('property_type_id', $filters['property_type_id']);
    //     }

    //     if (! empty($filters['property_status_id'])) {
    //         $query->where('property_status_id', $filters['property_status_id']);
    //     }

    //     if (! empty($filters['property_finishing_type_id'])) {
    //         $query->where('property_finishing_type_id', $filters['property_finishing_type_id']);
    //     }

    //     if (! empty($filters['price_min'])) {
    //         $query->where('sale_price', '>=', $filters['price_min']);
    //         $query->where('rent_price_monthly', '>=', $filters['price_min']);
    //     }

    //     if (! empty($filters['price_max'])) {
    //         $query->where('sale_price', '<=', $filters['price_max']);
    //         $query->where('rent_price_monthly', '<=', $filters['price_max']);
    //     }

    //     if (! empty($filters['bathrooms'])) {
    //         $query->where('bathrooms', $filters['bathrooms']);
    //     }

    //     if (! empty($filters['bedrooms'])) {
    //         $query->where('bedrooms', $filters['bedrooms']);
    //     }

    //     // // ✅ هنا نعدل البحث في الغرف
    //     // if (! empty($filters['bedrooms'])) {
    //     //     $query->where(function ($q) use ($filters) {
    //     //         $q->where('bedrooms', $filters['bedrooms'])
    //     //             ->orWhereHas('units', function ($sub) use ($filters) {
    //     //                 $sub->where('bedrooms', $filters['bedrooms']);
    //     //             });
    //     //     });
    //     // }
    //     // // ✅ وهنا للحمامات
    //     // if (! empty($filters['bathrooms'])) {
    //     //     $query->where(function ($q) use ($filters) {
    //     //         $q->where('bathrooms', $filters['bathrooms'])
    //     //             ->orWhereHas('units', function ($sub) use ($filters) {
    //     //                 $sub->where('bathrooms', $filters['bathrooms']);
    //     //             });
    //     //     });
    //     // }

    //     return $query;
    // }

    public function scopeFilter($query, $filters = [])
    {
        // City
        if (! empty($filters['city_id'])) {
            $query->where('city_id', $filters['city_id']);
        }

        // Neighborhood
        if (! empty($filters['neighborhood_id'])) {
            $query->where('neighborhood_id', $filters['neighborhood_id']);
        }

        // is_archived
        if (isset($filters['is_archived'])) {
            $query->where('is_archived', $filters['is_archived']);
        }

        // Property Type
        if (! empty($filters['property_type_id'])) {
            $query->where('property_type_id', $filters['property_type_id']);
        }

        // Purpose (sale/rent)
        if (! empty($filters['purpose'])) {
            $query->where('purpose', $filters['purpose']);
        }

        // Price Range - FIXED
        if (! empty($filters['price_min']) || ! empty($filters['price_max'])) {
            $query->where(function ($q) use ($filters) {
                // For sale properties
                $q->where(function ($sub) use ($filters) {
                    $sub->where('purpose', 'sale')
                        ->when(! empty($filters['price_min']), fn($q) => $q->where('sale_price', '>=', $filters['price_min']))
                        ->when(! empty($filters['price_max']), fn($q) => $q->where('sale_price', '<=', $filters['price_max']));
                })
                // For rent properties
                    ->orWhere(function ($sub) use ($filters) {
                        $sub->where('purpose', 'rent')
                            ->when(! empty($filters['price_min']), fn($q) => $q->where('rent_price_monthly', '>=', $filters['price_min']))
                            ->when(! empty($filters['price_max']), fn($q) => $q->where('rent_price_monthly', '<=', $filters['price_max']));
                    });
            });
        }

        // Area Range
        if (! empty($filters['area_min'])) {
            $query->where('area', '>=', $filters['area_min']);
        }
        if (! empty($filters['area_max'])) {
            $query->where('area', '<=', $filters['area_max']);
        }

        // Bathrooms
        if (! empty($filters['bathrooms'])) {
            if ($filters['bathrooms'] === '7+') {
                $query->where('bathrooms', '>=', 7);
            } else {
                $query->where('bathrooms', $filters['bathrooms']);
            }
        }

        // Bedrooms
        if (! empty($filters['bedrooms'])) {
            if ($filters['bedrooms'] === '5+') {
                $query->where('bedrooms', '>=', 5);
            } else {
                $query->where('bedrooms', $filters['bedrooms']);
            }
        }

        return $query;
    }

    public function rentalContracts()
    {
        return $this->hasMany(RentalContract::class);
    }

    public function activeRentalContract()
    {
        return $this->hasOne(RentalContract::class)->where('status', RentalContractStatus::ACTIVE->value)->latest();
    }

    /////////////////////////////////////// NEW
    public function deals()
    {
        return $this->belongsToMany(Deal::class, 'deal_property');
    }

    //////////////////////////////////// LABELS
    public function getPurposeLabelAttribute()
    {
        return [
            'sale' => 'بيع',
            'rent' => 'تأجير',
        ][$this->purpose] ?? $this->purpose;
    }

    public function getPurposeColorAttribute()
    {
        return [
            'sale' => 'badge-sale', // مثال: أخضر
            'rent' => 'badge-rent', // مثال: أزرق
        ][$this->purpose] ?? 'badge-secondary';
    }

    public function getPrice(): ?int
    {
        if (! empty($this->sale_price)) {
            return $this->sale_price;
        }

        if (! empty($this->rent_price_monthly)) {
            return $this->rent_price_monthly;
        }

        if (! empty($this->rent_price_quarterly)) {
            return $this->rent_price_quarterly;
        }

        if (! empty($this->rent_price_semi_annually)) {
            return $this->rent_price_semi_annually;
        }

        if (! empty($this->rent_price_annually)) {
            return $this->rent_price_annually;
        }

        return null; // مفيش سعر
    }

}
