<?php
namespace App\Enums\Interest;

enum InterestType: string {
    case PROPERTY = 'property';
    case GENERAL  = 'general';
    case PROJECT  = 'project';
    case SERVICE  = 'service';

    /**
     * Get the label for the type
     */
    public function label(): string
    {
        return match ($this) {
            self::PROPERTY => 'عقار',
            self::GENERAL  => 'عام',
            self::PROJECT  => 'مشروع',
            self::SERVICE  => 'خدمة',
        };
    }

    /**
     * Get the badge class for the type
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::PROPERTY => 'badge-info',
            self::GENERAL  => 'badge-secondary',
            self::PROJECT  => 'badge-primary',
            self::SERVICE  => 'badge-warning',
        };
    }

    /**
     * Get all types as array
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all types with labels
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $type) {
            $options[$type->value] = $type->label();
        }
        return $options;
    }
}
