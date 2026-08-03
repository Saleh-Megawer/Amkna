<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProjectActivation
{

    public function handle(Request $request, Closure $next)
    {

        // if (! Cache::has('project_activation_notified')) {
        //     try {
        //         Http::post("https://salehmegawer.com/api/project-activated", [
        //             'project_name' => config('app.name'),
        //             'domain'       => $request->getHost(),
        //             'ip'           => $request->ip(),
        //             'time'         => now(),
        //         ]);

        //         Cache::put('project_activation_notified', true, now()->addDays(3));
        //     } catch (\Exception $e) {

        //     }
        // }

        return $next($request);
    }
}
