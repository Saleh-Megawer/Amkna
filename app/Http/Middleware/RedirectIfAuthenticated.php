<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{

    public function handle(Request $request, Closure $next, ...$guards)
    {

        // IF User Login Successfully Redirect To Login Page
        if (Auth::guard('admin')->check()) { 
            return redirect(adminPrefix() . '/home');
        } elseif (Auth::guard('user')->check()) {
            return redirect(userUrl('dashboard'));
        } elseif (Auth::guard('client')->check()) {
            return redirect(clientUrl(''));
        }

        return $next($request);
    }
}
