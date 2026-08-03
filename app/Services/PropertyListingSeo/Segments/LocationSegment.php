<?php

namespace App\Services\PropertyListingSeo\Segments;

use App\Services\PropertyListingSeo\Filters;
use App\Services\PropertyListingSeo\LabelResolver;
use App\Services\PropertyListingSeo\Format\TitleFormats;

class LocationSegment implements Segment
{
    public function key(): string
    {
        return 'location';
    }

    public function order(): int
    {
        return 50;
    }

    public function priority(): int
    {
        return 60;
    }

    public function phrase(Filters $filters, LabelResolver $labels): ?string
    {
        $label = null;

        // Future-ready: compound filter. Resolve $filters->compoundId()
        // through the Compound model and assign it to $label when available.

        if ($label === null && $filters->neighborhoodId() !== null) {
            $label = $labels->neighborhoodName($filters->neighborhoodId());
        }

        if ($label === null && $filters->cityId() !== null) {
            $label = $labels->cityName($filters->cityId());
        }

        if ($label !== null) {
            return TitleFormats::location($label);
        }

        // Country-wide fallback: "عقارات للبيع في مصر" when only a purpose is active.
        if ($filters->purpose() !== null && $filters->propertyTypeId() === null) {
            return __('seo.location.country');
        }

        return null;
    }
}
