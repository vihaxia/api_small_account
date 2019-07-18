<?php

namespace App\Http\Middleware;

use App\Model\Record;
use App\Model\User;
use Closure;
use Illuminate\Support\Facades\Redis;

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

        if (!$request->input('X-WX-Skey')) {
            echo json_encode([
                'code' => '-1',
                'error' => '缺少头信息：X-WX-Skey'
            ]);
            exit();
        }

        $user = User::where(['skey' => $request->input('X-WX-Skey')])->find();

        if ($user) {
            Redis::set($user['skey'], $user['id']);
        }

        return $next($request);
    }
}
