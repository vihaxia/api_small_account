<?php

namespace App\Http\Controllers;
use App\Model\User;
use Illuminate\Http\Request;
use jmluang\weapp\Constants;
use jmluang\weapp\WeappLoginInterface as LoginInterface;

class LoginController extends Controller
{

    protected $redis;

    public function __construct()
    {
        $this->redis = app('redis.connection');
    }
    /**
     * 首次登陆
     * @param LoginInterface $login
     * @return array
     */
    public function login(LoginInterface $login)
    {
        $result = $login::login();
        if ($result['loginState'] === Constants::S_AUTH) {
            $user = User::where(['skey' => $result['userinfo']['skey']])->first();
            if ($user) {
                $this->redis->setex($user['skey'], 7200, $user['id']);
            }
            // 成功地响应会话信息
            return [
                'code' => 0,
                'data' => $result['userinfo']
            ];
        }

        return [
            'code' => -1,
            'error' => $result['error']
        ];

    }

    /**
     * 登陆过就使用这个接口
     * @param LoginInterface $login
     * @return array
     */
    public function user(LoginInterface $login, Request $request)
    {
        $result = $login::check();
        if ($result['loginState'] === Constants::S_AUTH && $this->redis->exists($request->header('X-WX-Skey'))) {
            return [
                'code' => 0,
                'data' => $result['userinfo']
            ];
        } else {
            return [
                'code' => -1,
                'data' => []
            ];
        }
    }
}