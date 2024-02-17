<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'BTE-Of3PbQncRCpcbIun-MeMjJ668Bys',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yiiframe\gii\Module',
        // 'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*'],
        
        'generators' => [
            'model' => [
                'class' => \yiiframe\gii\generators\model\Generator::class,
                'templates' => [
                    'yiiframe' => '@common/components/gii/model/yiiframe',
                    'default' => '@vendor/hjp1011/yii2-gii/src/generators/model/default',
                ]
            ],
            'crud' => [
                'class' => \common\components\gii\crud\Generator::class,
                'templates' => [
                    'yiiframe' => '@common/components/gii/crud/yiiframe',
                    'default' => '@vendor/hjp1011/yii2-gii/src/generators/crud/default',
                ]
            ],
            'api' => [
                'class' => \common\components\gii\api\Generator::class,
                'templates' => [
                    'yiiframe' => '@common/components/gii/api/yiiframe',
                    'default' => '@common/components/gii/api/default',
                ]
            ],
        ],
    ];
}

return $config;
