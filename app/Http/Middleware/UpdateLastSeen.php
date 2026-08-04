<?php

namespace App\Http\Middleware;

use App\Services\AdminLastSeenUpdater;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::guard('admin')->check()) {
            return $next($request);
        }

        if ($request->isMethod('GET') && ! $request->expectsJson()) {
            AdminLastSeenUpdater::touch();
        }

        return $next($request);
    }
}
