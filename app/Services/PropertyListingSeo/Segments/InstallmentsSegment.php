<?php

namespace App\Services\PropertyListingSeo\Segments;

use App\Services\PropertyListingSeo\Filters;
use App\Services\PropertyListingSeo\LabelResolver;
use App\Services\PropertyListingSeo\Format\TitleFormats;

class InstallmentsSegment implements Segment
{
    public function key(): string
    {
        return 'installments';
    }

    public function order(): int
    {
        return 40;
    }

    public function priority(): int
    {
        return 70;
    }

    public function phrase(Filters $filters, LabelResolver $labels): ?string
    {
        return $filters->installments() ? TitleFormats::installments() : null;
    }
}
