<?php

namespace App\Http\Controllers\Api\V1;

use App\Model\User;
use Iwanli\Wxxcx\Wxxcx;

class UserController extends Controller
{

    protected $wxxcx;

    public function __construct(Wxxcx $wxxcx)
    {
        $this->wxxcx = $wxxcx;
    }

    public function wxLogin() {
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
            return $this->error($wxUserInfo['message']);
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

        return $this->success($wxUserInfo);
    }

}
