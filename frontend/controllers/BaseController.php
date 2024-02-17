<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\traits\BaseAction;
//use addons\Monitoring\common\behaviors\ActionLogBehavior;

/**
 * Class BaseController
 * @package frontend\controllers
 * @author YiiFrame <21931118@qq.com>
 */
class BaseController extends Controller
{
    use BaseAction;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
//            'actionLog' => [
//                'class' => ActionLogBehavior::class
//            ]
        ];
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        // 指定使用哪个语言翻译
        // Yii::$app->language = 'en';
        return parent::init();
    }
}