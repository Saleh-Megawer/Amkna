<?php

namespace App\Services\PropertyListingSeo\Format;

class ArabicNumber
{
    public static function toArabicIndic(int|float|string $number): string
    {
        $western = str_split('0123456789');
        $eastern = [];

        for ($i = 0; $i < 10; $i++) {
            $eastern[] = mb_chr(0x0660 + $i, 'UTF-8');
        }

        return str_replace($western, $eastern, (string) $number);
    }

    /**
     * Compact Arabic phrasing with word scaling:
     * 500      -> "٥٠٠"
     * 250000   -> "٢٥٠ ألف"
     * 1500000  -> "١.٥ مليون"
     * 8000000  -> "٨ مليون"
     */
    public static function compact(int $number): string
    {
        if ($number >= 1000000) {
            return self::decimal($number / 1000000).' مليون';
        }

        if ($number >= 1000) {
            return self::decimal($number / 1000).' ألف';
        }

        return self::toArabicIndic($number);
    }

    protected static function decimal(float $value): string
    {
        $rounded = rtrim(rtrim(number_format(round($value, 1), 1, '.', ''), '0'), '.');

        return self::toArabicIndic($rounded);
    }
}
