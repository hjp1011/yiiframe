<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'sourceLanguage' => 'zh-cn',
    'timeZone' => 'Asia/Shanghai',
    'bootstrap' => [
//        'queue', // 队列系统
        'common\components\Init', // 加载默认的配置
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@backend/runtime/cache'
        ],
        /** ------ redis配置 ------ **/
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
        /** ------ websocket redis配置 ------ **/
        'websocketRedis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 1,
        ],
        /** ------ 队列设置 ------ **/
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'redis' => 'redis', // 连接组件或它的配置
            'channel' => 'queue', // Queue channel key
            'as log' => 'yii\queue\LogBehavior',// 日志
        ],
        /** ------ 网站碎片管理 ------ **/
        'debris' => [
            'class' => 'common\components\Debris',
        ],
        /** ------ 格式化时间 ------ **/
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
        /** ------ 服务层 ------ **/
        'services' => [
            'class' => 'services\Application',
        ],
        /** ------ 访问设备信息 ------ **/
        'mobileDetect' => [
            'class' => 'Detection\MobileDetect',
        ],
        /** ------ 上传组件 ------ **/
        'uploadDrive' => [
            'class' => 'addons\Webuploader\common\components\UploadDrive',
        ],
        /** ------ 微信扩展 ------ **/
        'wechat' => [
                'class' => 'addons\Weixin\common\components\Wechat',
                'userOptions' => [],  // 用户身份类参数
                'sessionParam' => 'wechatUser', // 微信用户信息将存储在会话在这个密钥
                'returnUrlParam' => '_wechatReturnUrl', // returnUrl 存储在会话中
                'rebinds' => [
                    'cache' => 'addons\Weixin\common\components\WechatCache',
                ]
        ],
        /** ------ 二维码 ------ **/
        'qr' => [
            'class' => '\Da\QrCode\Component\QrCodeComponent',
            // ... 您可以在这里配置组件的更多属性
        ],
        /** ------ 支付 ------ **/
        'pay' => [
                'class' => 'addons\Pay\common\components\Pay',
        ],
        /** ------ 快递 ------ **/
        'logistics' => [
           'class' => 'addons\Logistics\common\components\Logistics',
        ],
        /** ------ 多语言 ------ **/
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'addon' => 'addon.php',
                    ],
                ],

            ],
        ],
        /** ------ httpClient ------ **/
        'httpClient' => [
            'class' => 'yii\httpclient\Client',
        ],
        
    ],
];
