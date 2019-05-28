<?php

namespace App\Http\Middleware;

use Closure;

class CheckIp
{
    const IP = [
        'vagrant' => '192.168.10.1',
        'home' => '116.94.61.207',
    ];

    public function handle($request, Closure $next)
    {
        if (!in_array($request->ip(), self::IP)) {
            return redirect('404');
        }
        return $next($request);
    }
}
