<?php

namespace App\Http\Controllers\Api\V1;

use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Iwanli\Wxxcx\Wxxcx;

class UserController extends Controller
{

    protected $wxxcx;

    public function __construct(Wxxcx $wxxcx)
    {
        $this->wxxcx = $wxxcx;
    }

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
                'weixin_session_key' => $weixinSessionKey,
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
        User::where('weapp_openid', $weappOpenid)->update($attributes);

        // 直接创建token并设置有效期
        $createToken = $user->createToken($user->weapp_openid);
        $createToken->token->expires_at = Carbon::now()->addDays(30);
        $createToken->token->save();
        $token = $createToken->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => "Bearer",
            'expires_in' => Carbon::now()->addDays(30),
            'data' => $user
        ], 200);
    }

    public function getWxUserInfo() {
        //code 在小程序端使用 wx.login 获取
        $code = request('code', '');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');

        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $loginInfo = $this->wxxcx->getLoginInfo($code);

        //获取解密后的用户信息
        $wxUserInfo = $this->wxxcx->getUserInfo($encryptedData, $iv);

        if (is_array($wxUserInfo)) {
            return response()->json([
                'code' => -1,
                'error' => $wxUserInfo['message']
            ], 400);
        }

        $wxUserInfo = json_decode($wxUserInfo, true);

        $wxUserInfo['token'] = md5(sha1($wxUserInfo['openId']. rand(10000, 99999))); // 接口请求凭证

        User::updateOrCreate(['openid' => $loginInfo['openid']], [
            'openid' => $loginInfo['openid'],
            'nickname' => $wxUserInfo['nickName'],
            'gender' => $wxUserInfo['gender'],
            'language' => $wxUserInfo['language'],
            'city' => $wxUserInfo['city'],
            'province' => $wxUserInfo['province'],
            'country' => $wxUserInfo['country'],
            'avatar' => $wxUserInfo['avatarUrl'],
            'token' => $wxUserInfo['token']
        ]);

        return $wxUserInfo;
    }

}
