<?php

namespace App\Http\Controllers;

use App\Model\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::find($this->userId);
        if ($user) {
            return [
                'code' => 888,
                'data' => $user['user_info']
            ];
        }

        return [
            'code' => -1,
            'error' => 'skey错误'
        ];
    }
}
