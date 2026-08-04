<?php

namespace App\Services;

use App\Models\Dashboard\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AdminLastSeenUpdater
{
    public const THROTTLE_SECONDS = 60;

    public const ONLINE_MINUTES = 2;

    public static function touch(?int $adminId = null): void
    {
        $adminId ??= Auth::guard('admin')->id();

        if (! $adminId) {
            return;
        }

        // Atomic throttle: cache hit = zero database queries, miss = one UPDATE.
        if (! Cache::add("admin_last_seen:{$adminId}", true, now()->addSeconds(self::THROTTLE_SECONDS))) {
            return;
        }

        Admin::whereKey($adminId)->update([
            'last_seen' => now(),
        ]);
    }
}
