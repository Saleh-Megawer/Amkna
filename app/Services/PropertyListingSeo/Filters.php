<?php

namespace App\Services\PropertyListingSeo;

use Illuminate\Http\Request;

/**
 * Normalized, typed view of the property-listing filters coming from the URL.
 *
 * New filters can be added by extending this class with a typed accessor;
 * the builder's segments and label resolver take care of the rest.
 */
class Filters
{
    public function __construct(protected array $input = [])
    {
    }

    public static function fromRequest(Request $request): self
    {
        return new self($request->all());
    }

    public function has(string $key): bool
    {
        $value = $this->input[$key] ?? null;

        return $value !== null && $value !== '';
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->input[$key] ?? $default;
    }

    public function purpose(): ?string
    {
        $value = $this->get('purpose');

        return in_array($value, ['sale', 'rent'], true) ? $value : null;
    }

    public function propertyTypeId(): ?int
    {
        return $this->has('property_type_id') ? (int) $this->get('property_type_id') : null;
    }

    public function cityId(): ?int
    {
        return $this->has('city_id') ? (int) $this->get('city_id') : null;
    }

    public function neighborhoodId(): ?int
    {
        return $this->has('neighborhood_id') ? (int) $this->get('neighborhood_id') : null;
    }

    public function compoundId(): ?int
    {
        return $this->has('compound_id') ? (int) $this->get('compound_id') : null;
    }

    public function developerId(): ?int
    {
        return $this->has('developer_id') ? (int) $this->get('developer_id') : null;
    }

    public function finishingTypeId(): ?int
    {
        return $this->has('finishing_type_id') ? (int) $this->get('finishing_type_id') : null;
    }

    public function bedrooms(): ?string
    {
        return $this->has('bedrooms') ? (string) $this->get('bedrooms') : null;
    }

    public function bathrooms(): ?string
    {
        return $this->has('bathrooms') ? (string) $this->get('bathrooms') : null;
    }

    public function priceMin(): ?int
    {
        return $this->has('price_min') ? (int) $this->get('price_min') : null;
    }

    public function priceMax(): ?int
    {
        return $this->has('price_max') ? (int) $this->get('price_max') : null;
    }

    public function areaMin(): ?int
    {
        return $this->has('area_min') ? (int) $this->get('area_min') : null;
    }

    public function areaMax(): ?int
    {
        return $this->has('area_max') ? (int) $this->get('area_max') : null;
    }

    public function paymentMethod(): ?string
    {
        return $this->has('payment_method') ? (string) $this->get('payment_method') : null;
    }

    public function installments(): bool
    {
        return $this->has('installments')
            || in_array($this->paymentMethod(), ['installment', 'installments'], true);
    }

    public function hasAnyActiveFilter(): bool
    {
        return $this->purpose() !== null
            || $this->propertyTypeId() !== null
            || $this->cityId() !== null
            || $this->neighborhoodId() !== null
            || $this->compoundId() !== null
            || $this->developerId() !== null
            || $this->finishingTypeId() !== null
            || $this->bedrooms() !== null
            || $this->bathrooms() !== null
            || $this->priceMin() !== null
            || $this->priceMax() !== null
            || $this->areaMin() !== null
            || $this->areaMax() !== null
            || $this->installments();
    }
}
