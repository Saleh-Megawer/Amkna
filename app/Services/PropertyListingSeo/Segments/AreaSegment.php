<?php

namespace App\Services\PropertyListingSeo\Segments;

use App\Services\PropertyListingSeo\Filters;
use App\Services\PropertyListingSeo\LabelResolver;
use App\Services\PropertyListingSeo\Format\TitleFormats;

class AreaSegment implements Segment
{
    public function key(): string
    {
        return 'area';
    }

    public function order(): int
    {
        return 70;
    }

    public function priority(): int
    {
        return 30;
    }

    public function phrase(Filters $filters, LabelResolver $labels): ?string
    {
        return TitleFormats::areaRange($filters->areaMin(), $filters->areaMax());
    }
}
