<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotClient
{
    public function handle($request, Closure $next)
    {


        /* Check If Not Have Auth go to login */
        if (!Auth::guard('client')->check()) {
            return redirect(url('login'));
        }

        return $next($request);
    }
}
