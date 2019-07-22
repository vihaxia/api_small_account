<?php

namespace App\Http\Controllers;

use App\Model\User;

class UserController extends Controller
{
    /**
     * 用户管理
     *
     * @author xialingfu
     * @return false|string
     */
    public function index() {
        $user = User::find($this->userId);
        if ($user) {
            return json_encode([
                'code' => 0,
                'data' => $user['user_info']
            ]);
        }

        return json_encode([
            'code' => -1,
            'error' => 'skey错误'
        ]);
    }
}
