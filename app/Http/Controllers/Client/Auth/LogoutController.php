<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    public function logout()
    {
        Auth::guard(clientGuardName())->logout();
        return redirect(appUrl(''));
    }
}
