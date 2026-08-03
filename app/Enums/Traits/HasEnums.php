<?php

namespace App\Enums\Traits;

trait HasEnums
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        $result = [];

        foreach (self::cases() as $case) {
            $result[$case->value] = $case->label();
        }

        return $result;
    }

    public static function colors(): array
    {
        $result = [];

        foreach (self::cases() as $case) {
            $result[$case->value] = method_exists($case, 'color')
                ? $case->color()
                : null;
        }

        return $result;
    }
}
