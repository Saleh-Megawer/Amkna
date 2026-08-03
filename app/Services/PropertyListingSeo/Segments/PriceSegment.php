<?php

namespace App\Services\PropertyListingSeo\Segments;

use App\Services\PropertyListingSeo\Filters;
use App\Services\PropertyListingSeo\LabelResolver;
use App\Services\PropertyListingSeo\Format\TitleFormats;

class PriceSegment implements Segment
{
    public function key(): string
    {
        return 'price';
    }

    public function order(): int
    {
        return 60;
    }

    public function priority(): int
    {
        return 40;
    }

    public function phrase(Filters $filters, LabelResolver $labels): ?string
    {
        return TitleFormats::priceRange($filters->priceMin(), $filters->priceMax());
    }
}
