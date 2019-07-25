<?php

namespace App\Http\Controllers\Api\V1;

use App\Model\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Dingo\Api\Routing\Helpers;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Helpers;

    protected $userId;

    public function __construct(Request $request)
    {
        $this->userId = User::where('weixin_session_key', $request->header('X-WX-Skey'))->find()['id'] ?? 0;
    }
}
