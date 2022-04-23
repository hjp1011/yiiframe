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
        
        /** ------ 多语言 ------ **/
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@backend/messages',
//                    'sourceLanguage' => 'zh-cn',
                    'fileMap' => [
                        'app' => 'app.php',
                        'addon' => 'addon.php',
                    ],
//                    'on missingTranslation' => ['\common\components\TranslationEventHandler', 'handleMissingTranslation']
                ],

            ],
        ],
    ],
];
