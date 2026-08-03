<?php
namespace App\Models\Dashboard;

use App\Enums\Source\SourceKey;
use App\Enums\Source\SourceType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dashboard\Crm\Client\Client;

class Source extends Model
{
    // Allow mass assignment for all attributes
    protected $guarded = [];

    // Cast DB values to Enum objects
    protected $casts = [
        'type' => SourceType::class,
        'key'  => SourceKey::class,
    ];

    /**
     * Scope: Filter by source type (Enum)
     */
    public function scopeType($query, SourceType $type)
    {
        return $query->where('type', $type->value);
    }

    /**
     * Scope: Filter by source key (Enum)
     */
    public function scopeKey($query, SourceKey $key)
    {
        return $query->where('key', $key->value);
    }

    /**
     * Shortcut scope: CLIENT + MANUAL combination
     */
    public function scopeClientManual($query)
    {
        return $query->type(SourceType::CLIENT)->key(SourceKey::MANUAL);
    }

    /**
     * Relationship: Source has many clients
     */
    public function clients()
    {
        return $this->hasMany(Client::class, 'source_id');
    }
}
