<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewShareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       
        View::share('globalPhoneData', [
            'countries' => countriesData(),
            'lengths'   => phoneNumberLengths(),
            'formats'   => phoneNumberFormats(),
        ]);

    }
}
