<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    public function logout()
    {
        Auth::guard(adminGuardName())->logout();
        return redirect(adminPrefix());
    }
}
