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
        if (!$request->header('token')) {
            response()->json([
                'code' => -1,
                'error' => '缺少头信息：token'
            ], 200);
            exit();
        }

        return $next($request);
    }
}
