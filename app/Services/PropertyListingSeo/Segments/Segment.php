<?php

namespace App\Services\PropertyListingSeo\Segments;

use App\Services\PropertyListingSeo\Filters;
use App\Services\PropertyListingSeo\LabelResolver;

interface Segment
{
    /**
     * Unique segment key.
     */
    public function key(): string;

    /**
     * Word-order weight; lower values appear earlier in the phrase.
     */
    public function order(): int;

    /**
     * Drop priority; higher values are kept longer when the title is truncated.
     */
    public function priority(): int;

    /**
     * Arabic phrase for this filter, or null when the filter is not active.
     */
    public function phrase(Filters $filters, LabelResolver $labels): ?string;
}
