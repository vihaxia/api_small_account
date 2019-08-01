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
        $user = User::where('token', $request->header('token'))->first();
        // 会员编号
        $this->userId = $user->id ?? 0;
    }

    /**
     * 成功返回
     *
     * @author xialingfu
     * @param $data
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data, $msg = "ok") {
        return response()->json([
            'code' => 0,
            'data' => $data
        ], 200);
    }


    /**
     * 失败返回
     *
     * @author xialingfu
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($msg = "fail") {
        return response()->json([
            'code' => -1,
            'error' => $msg
        ], 200);
    }

}
