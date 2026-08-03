<?php
namespace App\Http\Controllers\Dashboard\Settings;

trait SettingComponents
{
    /**
     * Dashboard Tabs
     */
    public static array $tabs = [
        'general' => 'الإعدادات العامة',
        'contact' => 'معلومات الاتصال',
        'social'  => 'روابط السوشيال ميديا',
    ];

    /**
     * Social Media Config
     * Used by helper: socialMedia()
     */
    public static array $socialMedia = [
        'facebook'  => [
            'icon'  => 'fa-brands fa-facebook-f',
            'color' => '#0165E1',
        ],
        'snapchat'  => [
            'icon'  => 'fa-brands fa-snapchat',
            'color' => '#FFFC00',
        ],
        'twitter'   => [
            'icon'  => 'fa-brands fa-x-twitter',
            'color' => '#000000',
        ],
        'instagram' => [
            'icon'  => 'fa-brands fa-instagram',
            'color' => '#E1306C',
        ],
        'youtube'   => [
            'icon'  => 'fa-brands fa-youtube',
            'color' => '#FF0000',
        ],
        'telegram'  => [
            'icon'  => 'fa-brands fa-telegram',
            'color' => '#0088CC',
        ],
        'whatsapp'  => [
            'icon'  => 'fa-brands fa-whatsapp',
            'color' => '#25D366',
        ],
        'tiktok'    => [
            'icon'  => 'fa-brands fa-tiktok',
            'color' => '#000000',
        ],
        'linkedin'  => [
            'icon'  => 'fa-brands fa-facebook-f',
            'color' => '#0165E1',
        ],

    ];

    /**
     * Quick helpers (optional but clean)
     */
    public static function tabNames(): array
    {
        return array_keys(self::$tabs);
    }

    public static function socialKeys(): array
    {
        return array_keys(self::$socialMedia);
    }
}
