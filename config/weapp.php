<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 小程序 APPID
    |--------------------------------------------------------------------------
    |
    | 这里填写你的小程序的 appid
    | 获取方法请参考 https://mp.weixin.qq.com/
    |
    */
    'appid' => env('WX_APPID', 'your AppID'),

    /*
    |--------------------------------------------------------------------------
    | 小程序 Secret
    |--------------------------------------------------------------------------
    |
    | 这里填写你的小程序的 secret
    | 获取方法请参考https://mp.weixin.qq.com/
    |
    */
    'secret' => env('WX_SECRET', 'your AppSecret'),

    /*
    |--------------------------------------------------------------------------
    | 小程序的官方接口
    |--------------------------------------------------------------------------
    |
    | 小程序登录时使用凭证 code 获取 session_key 和 openid 地址时使用的接口地址
    | 此处若官方没改变地址则不需要改变地址
    |
    */
    'code2session_url' => "https://api.weixin.qq.com/sns/jscode2session?",

    /*
    |--------------------------------------------------------------------------
    | 网络配置
    |--------------------------------------------------------------------------
    |
    | WxLoginExpires : 微信登录态有效期
    | NetworkTimeout : 网络请求超时时长（单位：毫秒）
    | 若要使用自定义配置，取消下面的备注即可
    |
    */
//    'WxLoginExpires' => 7200,
//    'NetworkTimeout' => 3000,

    'index_header_speech' => [
        1 => [
            '一身轻', // 1-100
            '呦...还可以，没送多少', // 101 - 5000
            '有那么一点点心痛...', // 5001 - 8000
            '不知不觉送了这么多？...', // 8001 - 11000
            '让我静一静...好吧？...', // 11001 - 20000
            '我有点晕...来扶住我...', // 20001 - 35000
            '还能说什么？我朋友多呗', // 35001 - 50000
            '你就扯皮吧...鬼信你送了这么多份子钱' // 50001 -
        ],

        2 => [
            '哇靠...没收到钱', // 1-100
            '还可以... 能改善一下伙食', // 101 - 5000
            '呦...可以买个大件儿咯！' // 8001
        ]
    ],

    'money_speech' => [
        1 => [
            ''
        ],

        2 => [
            '绝交吧',
            '你确定你没填错嘛',
            '你确定TA不是来搞笑的？',
            '我愿意相信你是填错了的',
            '怕不是...你前男友OR前女友？',

            '放开我，我要去潇洒',
            '帮我问下，TA还缺朋友嘛',
            '金主爸爸',
            '我要跟你叫盆友',
            '怎么办...好慌',
            '问问是不是弄错了...',
            '瞎几把扯淡'
        ]
    ],

    'index_body_speech' => [
        '生个哇，多来点份子凑凑奶粉钱',
        '我不管我不管，就是要收份子',
        '我有一个小愿望，就是能天天结婚，天天收份子...嘻嘻，对象肯定是同一个人啦~',
        '想让我送份子？我们不认识，哈哈哈哈',
        '如果能躺着赚钱，那该多好啊...',
        '哎...下个月工资又要全部送出去--!',
        '见证我们友情的时候来了！',
        '一个个的就想从朕手里骗钱...'
    ]
];
