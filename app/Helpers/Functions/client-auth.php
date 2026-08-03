<?php

/*
|--------------------------------------------------------------------------
| File Map
|--------------------------------------------------------------------------
|
| - clientPrefix()     → Return client route prefix
| - clientUrl()        → Generate client panel URL with optional language
| - clientGuardName()  → Return client guard name
| - clientAuth()       → Get authenticated client attribute
| - client()           → Get authenticated client model
| - clientHasAuth()    → Check if client is authenticated
| - clientId()         → Get authenticated client ID
|
*/

use App\Models\Dashboard\Crm\Client\Client;
use Illuminate\Support\Facades\Auth;

if (! function_exists('clientPrefix')) {
    /**
     * Get client route prefix
     *
     * @return string
     */
    function clientPrefix()
    {
        return 'client';
    }
}

if (! function_exists('clientUrl')) {
    /**
     * Generate client URL with optional language prefix
     *
     * @param string $url
     * @param bool $setLang
     * @return string
     */
    function clientUrl(string $url = '', bool $setLang = true)
    {
        $segments = [];

        if ($setLang) {
            $segments[] = lang(); // Returns current language (ex: ar, en)
        }

        $segments[] = clientPrefix();

        if (! empty($url)) {
            $segments[] = trim($url, '/');
        }

        return url(implode('/', $segments));
    }
}

if (! function_exists('clientGuardName')) {
    /**
     * Get client guard name
     *
     * @return string
     */
    function clientGuardName()
    {
        return 'client';
    }
}

if (! function_exists('clientAuth')) {
    /**
     * Get authenticated client attribute dynamically
     *
     * @param string $get
     * @return mixed|null
     */
    function clientAuth($get)
    {
        if (Auth::guard(clientGuardName())->check()) {
            return auth(clientGuardName())->user()->$get;
        }

        return null;
    }
}

if (! function_exists('client')) {
    /**
     * Get authenticated client model
     *
     * @return Client|null
     */
    function client(): ?Client
    {
        return auth(clientGuardName())->user();
    }
}

if (! function_exists('clientHasAuth')) {
    /**
     * Check if client is authenticated
     *
     * @return bool
     */
    function clientHasAuth()
    {
        return Auth::guard(clientGuardName())->check();
    }
}

if (! function_exists('clientId')) {
    /**
     * Get authenticated client ID
     *
     * @return int|null
     */
    function clientId()
    {
        return clientAuth('id');
    }
}
