<?php

namespace App\Enums\Deal;

enum DealPurpose: string
{
    case BUY = 'buy';
    case RENT = 'rent';

    /**
     * Get the label for the purpose
     */
    public function label(): string
    {
        return match($this) {
            self::BUY => 'شراء',
            self::RENT => 'إيجار',
        };
    }

    /**
     * Get the badge class for the purpose
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::BUY => 'badge-info',
            self::RENT => 'badge-warning',
        };
    }

    /**
     * Get the icon SVG for the purpose
     */
    public function icon(): string
    {
        return match($this) {
            self::BUY => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z"/><path d="M16 10v-2"/><path d="M8 10v-2"/><path d="M9 17l6 0"/><path d="M10 14l4 0"/><path d="M5 10v9a3 3 0 0 0 3 3h8a3 3 0 0 0 3 -3v-9"/></svg>',
            self::RENT => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"/><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"/><path d="M12 12l0 .01"/><path d="M3 13a20 20 0 0 0 18 0"/></svg>',
        };
    }

    /**
     * Get all purposes as array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all purposes with labels
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $purpose) {
            $options[$purpose->value] = $purpose->label();
        }
        return $options;
    }
}
