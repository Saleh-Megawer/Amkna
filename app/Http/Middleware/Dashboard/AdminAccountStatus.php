<?php

namespace App\Http\Middleware\Dashboard;

use App\Http\Controllers\Dashboard\Auth\LogoutController;
use Closure;
use Illuminate\Http\Request;

class AdminAccountStatus
{

    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Check IF Auth Status Is Active
        if (adminAuth('status') < 1) {
            $logoutController = new LogoutController;
            $logoutController->logout();
        }
        return $next($request);
    }
}
