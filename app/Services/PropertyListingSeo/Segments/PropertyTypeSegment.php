<?php

namespace App\Services\PropertyListingSeo\Segments;

use App\Services\PropertyListingSeo\Filters;
use App\Services\PropertyListingSeo\LabelResolver;
use App\Services\PropertyListingSeo\Format\TitleFormats;

class PropertyTypeSegment implements Segment
{
    public function key(): string
    {
        return 'type';
    }

    public function order(): int
    {
        return 10;
    }

    public function priority(): int
    {
        return 90;
    }

    public function phrase(Filters $filters, LabelResolver $labels): ?string
    {
        $name = $labels->propertyTypeName($filters->propertyTypeId());

        return $name !== null ? TitleFormats::pluralType($name) : null;
    }
}
