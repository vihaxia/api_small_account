<?php

namespace App\Http\Controllers\Api\V1;

use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 用户管理
     *
     * @author xialingfu
     * @return false|string
     */
//    public function index() {
//        $user = User::find($this->userId);
//        if ($user) {
//            return response()->json([
//                'code' => 0,
//                'data' => $user['user_info']
//            ]);
//        }
//
//        return response()->json([
//            'code' => -1,
//            'error' => 'skey错误'
//        ]);
//    }

    public function weappLogin(Request $request)
    {
        $code = $request->code;
        // 根据 code 获取微信 openid 和 session_key
        $miniProgram = \EasyWeChat::miniProgram();
        $data = $miniProgram->auth->session($code);
        if (isset($data['errcode'])) {
            return $this->response->errorUnauthorized('code已过期或不正确');
        }
        $weappOpenid = $data['openid'];
        $weixinSessionKey = $data['session_key'];
        $nickname = $request->nickname;
        $avatar = $request->avatar;//拿到分辨率高点的头像
        $country = $request->country?$request->country:'';
        $province = $request->province?$request->province:'';
        $city = $request->city?$request->city:'';
        $gender = $request->gender == '1' ? '1' : '2';//没传过性别的就默认女的吧，体验好些
        $language = $request->language?$request->language:'';

        //找到 openid 对应的用户
        $user = User::where('weapp_openid', $weappOpenid)->first();
        //没有，就注册一个用户
        if (!$user) {
            $user = User::create([
                'weapp_openid' => $weappOpenid,
                'weapp_session_key' => $weixinSessionKey,
                'weapp_avatar' => $avatar,
                'nickname' => $nickname,
                'country' => $country,
                'province' => $province,
                'city' => $city,
                'gender' => $gender,
                'language' => $language,
                'created_at' => now()
            ]);
        }
        //如果注册过的，就更新下下面的信息
        $attributes['updated_at'] = now();
        $attributes['weixin_session_key'] = $weixinSessionKey;
        $attributes['weapp_avatar'] = $avatar;
        if ($nickname) {
            $attributes['nickname'] = $nickname;
        }
        if ($request->gender) {
            $attributes['gender'] = $gender;
        }
        // 更新用户数据
        DB::connection()->enableQueryLog();
        $user->update($attributes);

        // 直接创建token并设置有效期
        $createToken = $user->createToken($user->weapp_openid);
        $createToken->token->expires_at = Carbon::now()->addDays(30);
        $createToken->token->save();
        $token = $createToken->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => "Bearer",
            'expires_in' => Carbon::now()->addDays(30),
            'data' => $user,
            'sql' => DB::getQueryLog()
        ], 200);
    }
}
