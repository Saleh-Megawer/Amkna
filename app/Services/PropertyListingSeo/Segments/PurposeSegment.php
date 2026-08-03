<?php

namespace App\Services\PropertyListingSeo\Segments;

use App\Services\PropertyListingSeo\Filters;
use App\Services\PropertyListingSeo\LabelResolver;
use App\Services\PropertyListingSeo\Format\TitleFormats;

class PurposeSegment implements Segment
{
    public function key(): string
    {
        return 'purpose';
    }

    public function order(): int
    {
        return 30;
    }

    public function priority(): int
    {
        return 100;
    }

    public function phrase(Filters $filters, LabelResolver $labels): ?string
    {
        return TitleFormats::purpose($filters->purpose());
    }
}
