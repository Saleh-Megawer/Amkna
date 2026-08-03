<?php

namespace App\Services\PropertyListingSeo;

use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Property\PropertyType;

/**
 * Resolves filter ids into human-readable Arabic labels.
 * Lookups are memoized so each label is fetched at most once per request.
 */
class LabelResolver
{
    protected array $cache = [];

    public function cityName(?int $id): ?string
    {
        return $this->resolve($id, 'city', fn () => optional(City::find($id))->name);
    }

    public function neighborhoodName(?int $id): ?string
    {
        return $this->resolve($id, 'neighborhood', fn () => optional(Neighborhood::find($id))->name);
    }

    public function propertyTypeName(?int $id): ?string
    {
        return $this->resolve($id, 'type', fn () => optional(PropertyType::find($id))->name);
    }

    protected function resolve(?int $id, string $kind, callable $resolver): ?string
    {
        if ($id === null) {
            return null;
        }

        $key = $kind.':'.$id;

        if (! array_key_exists($key, $this->cache)) {
            $this->cache[$key] = $resolver();
        }

        return $this->cache[$key] ?: null;
    }
}
