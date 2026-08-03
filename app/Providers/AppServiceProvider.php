<?php
namespace App\Providers;

use App\Models\Interest;
use App\Observers\InterestObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);
        // Use Bootstrap 4
        Paginator::useBootstrapFour();
        //////////////////
        Interest::observe(InterestObserver::class);
        ////////////////////////////////////////
        $this->loadSiteSettings();

    }

    private function loadSiteSettings()
    {

        $data = Cache::remember('settings', 240, function () {

            $result = [
                'setting' => null,
                'about'   => null,
            ];

            try {

                // ----- SETTINGS TABLE -----
                if (Schema::hasTable('settings')) {

                    $cols = Schema::getColumnListing('settings');

                    $wanted = [
                        'logo',
                        'footer_logo',
                        'website_name',
                        'website_desc',
                        //
                        'email',
                        'phone',
                        //
                        'facebook',
                        'snapchat',
                        'twitter',
                        'instagram',
                        'youtube',
                        'telegram',
                        'whatsapp',
                        'tiktok',
                    ];

                    $select = array_values(array_intersect($wanted, $cols));

                    if (! empty($select)) {
                        $result['setting'] = DB::table('settings')->select($select)->first();
                    }
                }

                // ----- ABOUT / TRANSLATIONS -----
                // if (Schema::hasTable('about_translations') && Schema::hasTable('abouts')) {

                //     $aboutCols      = Schema::getColumnListing('abouts');
                //     $aboutTransCols = Schema::getColumnListing('about_translations');

                //     $select = [];

                //     if (in_array('avatar', $aboutCols)) {
                //         $select[] = 'abouts.avatar';
                //     }

                //     if (in_array('bio', $aboutTransCols)) {
                //         $select[] = 'about_translations.bio';
                //     }

                //     if (! empty($select)) {
                //         $result['about'] = DB::table('about_translations')
                //             ->join('abouts', 'abouts.id', '=', 'about_translations.about_id')
                //             ->where('locale', lang())
                //             ->select($select)
                //             ->first();
                //     }
                // }

            } catch (\Throwable $e) {
                Log::warning('Failed to load settings cache: ' . $e->getMessage());
            }

            return $result;
        });

        $settings = $data['setting'];
        $about    = $data['about'];

        Config::set('settings', [

            // Main
            'logo'    => optional($settings)->logo,
            'footer_logo'    => optional($settings)->footer_logo,
            // 'site_icon' => optional($settings)->website_icon,
            // 'site_name' => optional($settings)->website_name,
            //  'site_desc' => optional($settings)->website_desc,

            // About
            //  'bio'       => optional($about)->bio,
            //  'avatar'    => optional($about)->avatar,

            // Contact
            'contact' => [
                'email' => optional($settings)->email,
                'phone' => optional($settings)->phone,
            ],

            // Social
            'social'  => [
                'facebook'  => optional($settings)->facebook,
                'snapchat'  => optional($settings)->snapchat,
                'twitter'   => optional($settings)->twitter,
                'instagram' => optional($settings)->instagram,
                'youtube'   => optional($settings)->youtube,
                'telegram'  => optional($settings)->telegram,
                'whatsapp'  => optional($settings)->whatsapp,
                'tiktok'    => optional($settings)->tiktok,
            ],
        ]);

      //  dd(config('settings'));
    }

}
