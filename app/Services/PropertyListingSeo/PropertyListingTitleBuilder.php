<?php

namespace App\Services\PropertyListingSeo;

use App\Services\PropertyListingSeo\Segments\AreaSegment;
use App\Services\PropertyListingSeo\Segments\BathroomsSegment;
use App\Services\PropertyListingSeo\Segments\BedroomsSegment;
use App\Services\PropertyListingSeo\Segments\InstallmentsSegment;
use App\Services\PropertyListingSeo\Segments\LocationSegment;
use App\Services\PropertyListingSeo\Segments\PriceSegment;
use App\Services\PropertyListingSeo\Segments\PropertyTypeSegment;
use App\Services\PropertyListingSeo\Segments\PurposeSegment;
use Illuminate\Http\Request;

/**
 * Builds natural Arabic SEO titles for the properties listing page from the
 * active URL filters. The controller never assembles strings manually.
 *
 * Adding a new filter:
 *  1. add a typed accessor to Filters
 *  2. create a Segment class (order + priority + phrase)
 *  3. register it in defaultSegments()
 */
class PropertyListingTitleBuilder
{
    protected Filters $filters;

    protected int $maxLength = 52;

    public function __construct(protected LabelResolver $labels)
    {
    }

    public function forRequest(Request $request): static
    {
        $this->filters = Filters::fromRequest($request);

        return $this;
    }

    public function forFilters(Filters $filters): static
    {
        $this->filters = $filters;

        return $this;
    }

    public function build(): SeoResult
    {
        if (! $this->filters->hasAnyActiveFilter()) {
            return new SeoResult(
                pageTitle: __('seo.defaults.title'),
                heading: __('seo.defaults.heading'),
                metaDescription: __('seo.defaults.description'),
            );
        }

        $title = $this->assemble($this->maxLength);
        $heading = $this->heading();

        return new SeoResult(
            pageTitle: $title,
            heading: $heading,
            metaDescription: $title.' - '.__('seo.description_suffix'),
        );
    }

    /**
     * Purpose-only heading: "عقارات للبيع" / "عقارات للإيجار",
     * or the default phrase when no purpose is active.
     */
    protected function heading(): string
    {
        $purpose = $this->filters->purpose();

        if ($purpose === null) {
            return __('seo.defaults.heading');
        }

        return \App\Services\PropertyListingSeo\Format\TitleFormats::defaultNoun()
            .' '
            .\App\Services\PropertyListingSeo\Format\TitleFormats::purpose($purpose);
    }

    /**
     * Resolves active segments into a single natural Arabic phrase.
     * Drops lower-priority segments when the phrase exceeds the length budget.
     */
    protected function assemble(int $maxLength): string
    {
        $resolved = $this->resolveSegments();

        // Always keep a noun when no property type is present.
        if (! $this->contains($resolved, 'type')) {
            $resolved[] = [
                'key'      => 'noun',
                'order'    => 5,
                'priority' => 95,
                'phrase'   => \App\Services\PropertyListingSeo\Format\TitleFormats::defaultNoun(),
            ];
        }

        $resolved = collect($resolved)->sortBy('order')->values();

        if (mb_strlen($this->join($resolved)) > $maxLength) {
            foreach (collect($resolved)->sortBy('priority')->values() as $candidate) {
                if (mb_strlen($this->join($resolved)) <= $maxLength) {
                    break;
                }

                if (in_array($candidate['key'], ['purpose', 'noun'], true)) {
                    continue;
                }

                $resolved = $resolved->reject(fn (array $item) => $item['key'] === $candidate['key'])->values();
            }
        }

        return $this->join($resolved);
    }

    protected function resolveSegments(): array
    {
        $resolved = [];

        foreach ($this->defaultSegments() as $segment) {
            $phrase = $segment->phrase($this->filters, $this->labels);

            if ($phrase !== null && $phrase !== '') {
                $resolved[] = [
                    'key'      => $segment->key(),
                    'order'    => $segment->order(),
                    'priority' => $segment->priority(),
                    'phrase'   => $phrase,
                ];
            }
        }

        return $resolved;
    }

    protected function contains(array $resolved, string $key): bool
    {
        return collect($resolved)->contains(fn (array $item) => $item['key'] === $key);
    }

    protected function join($resolved): string
    {
        $phrases = $resolved->map(fn (array $item) => $item['phrase'])
            ->filter(fn ($phrase) => $phrase !== null && $phrase !== '')
            ->values()
            ->all();

        return implode(' ', $phrases);
    }

    /**
     * Ordered registry of title segments (word order). Adding a new filter is
     * just registering its segment here.
     */
    protected function defaultSegments(): array
    {
        return [
            new PropertyTypeSegment(),
            new BedroomsSegment(),
            new BathroomsSegment(),
            new PurposeSegment(),
            new InstallmentsSegment(),
            new LocationSegment(),
            new PriceSegment(),
            new AreaSegment(),
        ];
    }
}
