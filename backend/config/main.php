<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'main', // 默认控制器
    'bootstrap' => ['log'],
    'modules' => [
        /** ------ 公用模块 ------ **/
        'common' => [
            'class' => 'backend\modules\common\Module',
        ],
        /** ------ 基础模块 ------ **/
        'base' => [
            'class' => 'backend\modules\base\Module',
        ],
    ],
    'components' => [

        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\backend\Member',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'idParam' => '__backend',
            'on afterLogin' => function ($event) {
                Yii::$app->services->backendMember->lastLogin($event->identity);
            },
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
            'timeout' => 86400,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/' . date('Y-m/d') . '.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            // 'linkAssets' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [],
                    'sourcePath' => null,
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],  // 去除 bootstrap.css
                    'sourcePath' => null,
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [],  // 去除 bootstrap.js
                    'sourcePath' => null,
                ],
            ],
        ],
        
    ],
    'container' => [
        'definitions' => [
            'yii\widgets\LinkPager' => [
                'nextPageLabel' => '<i class="icon ion-ios-arrow-right"></i>',
                'prevPageLabel' => '<i class="icon ion-ios-arrow-left"></i>',
                'lastPageLabel' => '<i class="icon ion-ios-arrow-right"></i><i class="icon ion-ios-arrow-right"></i>',
                'firstPageLabel' => '<i class="icon ion-ios-arrow-left"></i><i class="icon ion-ios-arrow-left"></i>',
            ]
        ],
        'singletons' => [
            // 依赖注入容器单例配置
        ]
    ],
    'controllerMap' => [
        'file' => 'addons\Webuploader\common\controllers\FileBaseController', // 文件上传公共控制器
        'uedit' => 'addons\Ueditor\common\widgets\ueditor\UeditorController', // 百度编辑器
        'select-map' => 'addons\Map\common\widgets\selectmap\MapController', // 经纬度选择
        'crop' => 'addons\Cropper\common\widgets\cropper\CropperController', // 图片裁剪
    ],
    'as cors' => [
        'class' => \yii\filters\Cors::class,
    ],
    'params' => $params,
];
