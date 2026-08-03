<?php
namespace App\Enums\OwnerAssociation;

use App\Enums\Traits\HasEnums;

enum RequestType: string {
    use HasEnums;

    case SUBSCRIPTION_PAYMENT = 'subscription_payment';
    case REPORT = 'report';
    // case COMPLAINT            = 'complaint';
    case MAINTENANCE = 'maintenance';
    case SERVICE     = 'service';
    case SUGGESTION  = 'suggestion';
    case INQUIRY     = 'inquiry';
    case EMERGENCY   = 'emergency';
    //  case GENERAL              = 'general';

    public function label(): string
    {
        return match ($this) {
            self::SUBSCRIPTION_PAYMENT => __('request_type.subscription_payment'),
            self::REPORT               => __('request_type.report'),
            //     self::COMPLAINT            => __('request_type.complaint'),
            self::MAINTENANCE          => __('request_type.maintenance'),
            self::SERVICE              => __('request_type.service'),
            self::SUGGESTION           => __('request_type.suggestion'),
            self::INQUIRY              => __('request_type.inquiry'),
            self::EMERGENCY            => __('request_type.emergency'),
            //    self::GENERAL              => __('request_type.general'),
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->map(fn($case) => [
                'id'   => $case->value,
                'name' => $case->label(),
            ])
            ->values()
            ->toArray();
    }

    public function color(): string
    {
        return match ($this) {
            self::SUBSCRIPTION_PAYMENT => 'bg-dark text-white',
            self::REPORT               => 'bg-warning text-dark',
            // self::COMPLAINT            => 'bg-danger text-white',
            self::MAINTENANCE          => 'bg-primary text-white',
            self::SERVICE              => 'bg-info text-white',
            self::SUGGESTION           => 'bg-success text-white',
            self::INQUIRY              => 'bg-secondary text-white',
            self::EMERGENCY            => 'bg-danger text-white',
            //  self::GENERAL              => 'bg-dark text-white',
        };
    }

    public function icon(): string
    {
        $w = '16';
        return match ($this) {
            self::REPORT               => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $w . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" /><path d="M12 16h.01" /></svg>',

            // self::COMPLAINT            => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $w . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>',

            self::MAINTENANCE          => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $w . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10h3v-3l-3.5 -3.5a6 6 0 0 1 8 8l6 6a2 2 0 0 1 -3 3l-6 -6a6 6 0 0 1 -8 -8l3.5 3.5" /></svg>',

            self::SERVICE              => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $w . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><path d="M12 12l0 .01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg>',

            self::SUGGESTION           => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $w . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12h1m8 -9v1m8 8h1m-15.4 -6.4l.7 .7m12.1 -.7l-.7 .7" /><path d="M9 16a5 5 0 1 1 6 0a3.5 3.5 0 0 0 -1 3a2 2 0 0 1 -4 0a3.5 3.5 0 0 0 -1 -3" /><path d="M9.7 17l4.6 0" /></svg>',

            self::INQUIRY              => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $w . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 16v.01" /><path d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" /></svg>',

            self::EMERGENCY            => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $w . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>',

            // self::GENERAL              => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $w . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17l6 0" /></svg>',

            self::SUBSCRIPTION_PAYMENT => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $w . '" height="' . $w . '" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M240,186.79c-91.64,44.77-132.36-42.35-224,2.42v-120c91.64-44.77,132.36,42.35,224-2.42Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><circle cx="128" cy="128" r="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="48" y1="96" x2="48" y2="144" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="208" y1="112" x2="208" y2="160" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>',
        };
    }

}
