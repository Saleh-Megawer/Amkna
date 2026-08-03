<?php

namespace App\Services\PropertyListingSeo\Segments;

use App\Services\PropertyListingSeo\Filters;
use App\Services\PropertyListingSeo\LabelResolver;
use App\Services\PropertyListingSeo\Format\TitleFormats;

class BedroomsSegment implements Segment
{
    public function key(): string
    {
        return 'bedrooms';
    }

    public function order(): int
    {
        return 20;
    }

    public function priority(): int
    {
        return 80;
    }

    public function phrase(Filters $filters, LabelResolver $labels): ?string
    {
        return TitleFormats::bedrooms($filters->bedrooms());
    }
}
