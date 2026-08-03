<?php

namespace App\Services\PropertyListingSeo\Format;

/**
 * Shared Arabic phrasing helpers used by the title segments.
 * Keeps formatting logic in one place so it can be reused by future filters.
 */
class TitleFormats
{
    public static function purpose(?string $purpose): ?string
    {
        return match ($purpose) {
            'sale' => __('seo.purpose.sale'),
            'rent' => __('seo.purpose.rent'),
            default => null,
        };
    }

    public static function bedrooms(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value === '5+') {
            return __('seo.bedrooms.plus', ['count' => ArabicNumber::toArabicIndic(5)]);
        }

        return __('seo.bedrooms.count', ['count' => ArabicNumber::toArabicIndic((int) $value)]);
    }

    public static function bathrooms(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value === '7+') {
            return __('seo.bathrooms.plus', ['count' => ArabicNumber::toArabicIndic(7)]);
        }

        return __('seo.bathrooms.count', ['count' => ArabicNumber::toArabicIndic((int) $value)]);
    }

    public static function priceRange(?int $min, ?int $max): ?string
    {
        if ($min === null && $max === null) {
            return null;
        }

        if ($min !== null && $max !== null && $min < $max) {
            return __('seo.price.between', [
                'from'     => ArabicNumber::compact($min),
                'to'       => ArabicNumber::compact($max),
                'currency' => __('seo.currency'),
            ]);
        }

        if ($min !== null) {
            return __('seo.price.from', [
                'value'    => ArabicNumber::compact($min),
                'currency' => __('seo.currency'),
            ]);
        }

        return __('seo.price.up_to', [
            'value'    => ArabicNumber::compact($max),
            'currency' => __('seo.currency'),
        ]);
    }

    public static function areaRange(?int $min, ?int $max): ?string
    {
        if ($min === null && $max === null) {
            return null;
        }

        if ($min !== null && $max !== null && $min < $max) {
            return __('seo.area.between', [
                'from' => ArabicNumber::toArabicIndic($min),
                'to'   => ArabicNumber::toArabicIndic($max),
            ]);
        }

        if ($min !== null) {
            return __('seo.area.from', ['value' => ArabicNumber::toArabicIndic($min)]);
        }

        return __('seo.area.up_to', ['value' => ArabicNumber::toArabicIndic($max)]);
    }

    public static function location(?string $label): ?string
    {
        return $label === null ? null : __('seo.location.in', ['place' => $label]);
    }

    public static function installments(): string
    {
        return __('seo.payment.installment');
    }

    public static function defaultNoun(): string
    {
        return __('seo.noun.default');
    }

    /**
     * Pluralize a property-type name for listing titles
     * ("شقة للبيع" reads better as "شقق للبيع"). Falls back to the original
     * name for types not in the dictionary.
     */
    public static function pluralType(string $name): string
    {
        $plural = [
            'شقة'          => 'شقق',
            'فيلا'         => 'فلل',
            'محل'          => 'محلات',
            'دوبلكس'       => 'دوبلكسات',
            'استوديو'      => 'استوديوهات',
            'أرض'          => 'أراضي',
            'مكتب'         => 'مكاتب',
            'عمارة'        => 'عمارات',
            'بيت'          => 'بيوت',
            'شاليه'        => 'شاليهات',
            'تاون هاوس'    => 'تاون هاوس',
            'بنتهاوس'      => 'بنتهاوس',
        ];

        return $plural[trim($name)] ?? trim($name);
    }
}
