<?php

namespace App\Http\Middleware;

use Closure;

class CheckWxSkey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->header('X-WX-Skey')) {
            response()->json([
                'error' => '缺少头信息：X-WX-Skey',
            ], 401);
            exit();
        }

        return $next($request);
    }
}
