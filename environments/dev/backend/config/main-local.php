<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => \common\components\gii\crud\Generator::class,
                'templates' => [
                    'yiiframe' => '@common/components/gii/crud/yiiframe',
                    'cate' => '@common/components/gii/crud/cate',
                    'flow' => '@common/components/gii/crud/flow',
                    'default' => '@vendor/yiisoft/yii2-gii/src/generators/crud/default',
                ]
            ],
            'model' => [
                'class' => \yii\gii\generators\model\Generator::class,
                'templates' => [
                    'yiiframe' => '@common/components/gii/model/yiiframe',
                    'cate' => '@common/components/gii/model/cate',
                    'flow' => '@common/components/gii/model/flow',
                    'default' => '@vendor/yiisoft/yii2-gii/src/generators/model/default',
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
