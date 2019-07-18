<?php

namespace App\Http\Controllers;
use jmluang\weapp\Constants;
use jmluang\weapp\WeappLoginInterface as LoginInterface;

class LoginController extends Controller
{
    /**
     * 首次登陆
     * @param LoginInterface $login
     * @return array
     */
    public function login(LoginInterface $login)
    {
        $result = $login::login();
        if ($result['loginState'] === Constants::S_AUTH) {
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
    public function user(LoginInterface $login)
    {
        $result = $login::check();

        if ($result['loginState'] === Constants::S_AUTH) {
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