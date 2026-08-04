<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\AdminLastSeenUpdater;

class LastSeenController extends Controller
{
    public function __invoke()
    {
        AdminLastSeenUpdater::touch();

        return response()->json(['ok' => true]);
    }
}
