<?php

namespace App\Services\PropertyListingSeo\Segments;

use App\Services\PropertyListingSeo\Filters;
use App\Services\PropertyListingSeo\LabelResolver;
use App\Services\PropertyListingSeo\Format\TitleFormats;

class BathroomsSegment implements Segment
{
    public function key(): string
    {
        return 'bathrooms';
    }

    public function order(): int
    {
        return 25;
    }

    public function priority(): int
    {
        return 55;
    }

    public function phrase(Filters $filters, LabelResolver $labels): ?string
    {
        return TitleFormats::bathrooms($filters->bathrooms());
    }
}
