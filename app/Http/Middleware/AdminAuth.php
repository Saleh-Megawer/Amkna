<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{

    public function prepareAdminInfo()
    {
        // // Admin Attr
        // $staticWhere = ['admin_id' => adminId()]; // Where

        // $adminAttr = AdminAttributes::where($staticWhere)->count();
        // if ($adminAttr == 0) {
        //     // Create New Row And Set admin_id = Auth Id
        //     AdminAttributes::create($staticWhere);
        // }

        // // Admin Port
        // $adminPort = AdminPortfolio::where($staticWhere)->count();
        // if ($adminPort == 0) {
        //     // Create New Row And Set admin_id = Auth Id
        //     AdminPortfolio::create($staticWhere);
        // }
    }

    public function handle(Request $request, Closure $next, ...$guards)
    {

        if (!Auth::guard('admin')->check()) {
            return redirect("/" . adminPrefix());
        } else {
            $this->prepareAdminInfo();
        }

        return $next($request);
    }

}
