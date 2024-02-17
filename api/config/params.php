<?php
return [
    /** ------ 日志记录 ------ **/
    'user.log' => true,
    'user.log.level' => YII_DEBUG ? ['success', 'info', 'warning', 'error'] : ['warning', 'error'], // 级别 ['success', 'info', 'warning', 'error']
    'user.log.except.code' => [200], // 不记录的code

    /** ------ token相关 ------ **/
    // token有效期是否验证 默认不验证
    'user.accessTokenValidity' => true,
    // token有效期 默认 2 小时
    'user.accessTokenExpire' => 2 * 60 * 60,
    // refresh token有效期是否验证 默认开启验证
    'user.refreshTokenValidity' => true,
    // refresh token有效期 默认30天
    'user.refreshTokenExpire' => 30 * 24 * 60 * 60,
    // 签名验证默认关闭验证，如果开启需了解签名生成及验证
    'user.httpSignValidity' => false,
    // 签名授权公钥秘钥
    'user.httpSignAccount' => [
        'doormen' => 'e3de3825cfbf',
    ],
    // 触发格式化返回
    'triggerBeforeSend' => true,

    /** ------ 非微信打开的时候是否开启微信模拟数据 ------ **/
    'simulateUser' => [
        'switch' => true,// 微信应用模拟用户检测开关
        'userInfo' => [
            'id' => 'oW6qtS0fitZTWHudEXa7ik',
            'nickname' => '微信用户',
            'name' => '微信用户',
            'avatar' => 'https://mmbiz.qpic.cn/mmbiz/icTdbqWNOwNRna42FI242Lcia07jQodd2FJGIYQfG0LAJGFxM4FbnQP6yfMxBgJ0F3YRqJCJ1aPAK2dQagdusBZg/0',
            'original' => [
                'openid' => 'oW6qtS0fitZTWHudEXa7ik',
                'nickname' => '微信用户',
                'sex' => 1,
                'language' => 'zh_CN',
                'city' => '武汉',
                'province' => '湖北',
                'country' => '中国',
                'headimgurl' => 'https://mmbiz.qpic.cn/mmbiz/icTdbqWNOwNRna42FI242Lcia07jQodd2FJGIYQfG0LAJGFxM4FbnQP6yfMxBgJ0F3YRqJCJ1aPAK2dQagdusBZg/0',
                'privilege' => [],
            ],
            'token' => '10_8ZUhjEP6s_nanE37Z7Zh3kFRA7ZhFRAALBtkCV1WE',
            'provider' => 'WeChat',
            'access_token' =>'63_-s4wh5Ct7IMVRc-erKpEjXaZDn7PHx6y5AdY-xr6VGQZ-KmpTrsIaWX7URcmsjEc4ND9JLgciWdhUKrtAi3tlYRHFJ3mHEiuT6rRoL4kmc4',
            'refresh_token' =>'63_fPeK4XfbCxhv-Twe_JoStEW81Jlz5gaFn2XXhaxpPJTRm--Bqfx2HSuaXkEdxjSjZj5cHnYyZmlqUol69GTv2rxg2qdEuHBMWogFyoC0B3I'
        ],
    ],

    /** ------ 当前的微信用户信息 ------ **/
    'wechatMember' => [],
];
