<?php
namespace App\Enums\OwnerAssociation;

use App\Enums\Traits\HasEnums;

enum RequestPriority: string {
    use HasEnums;

    case LOW    = 'low';
    case NORMAL = 'normal';
    case HIGH   = 'high';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::LOW    => __('priority.low'),
            self::NORMAL => __('priority.normal'),
            self::HIGH   => __('priority.high'),
            self::URGENT => __('priority.urgent'),
        };
    }

    // في RequestPriority Enum
    public function icon(): string
    {
        return match ($this) {
            self::LOW    => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trending-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l6 6l4 -4l8 8" /><path d="M21 10l0 7l-7 0" /></svg>',
            //
            self::NORMAL => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-minus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /></svg>',
            //
            self::HIGH   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>',
            //
            self::URGENT => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-triangle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0" /><path d="M12 16h.01" /></svg>',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LOW    => 'bg-secondary text-white',
            self::NORMAL => 'bg-info text-white',
            self::HIGH   => 'bg-warning text-white',
            self::URGENT => 'bg-danger text-white',
        };
    }
}
