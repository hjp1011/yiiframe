<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'html5',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'html5\controllers',
    'bootstrap' => ['log'],
    // 'catchAll' => ['site/offline'], // 全拦截路由(比如维护时可用)
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-html5',
        ],
        'user' => [
            'identityClass' => 'addons\Member\common\models\Member',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-html5', 'httpOnly' => true],
            'loginUrl' => ['site/login'],
            'idParam' => '__html5',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the html5
            'name' => 'advanced-html5',
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

    ],
    'params' => $params,
];
