<?php

namespace frontend\controllers;

use yii\web\Controller;
use addons\Pay\common\traits\PayNotify;

/**
 * 支付回调
 *
 * Class NotifyController
 * @package frontend\controllers
 * @author YiiFrame <21931118@qq.com>
 */
class NotifyController extends Controller
{
    use PayNotify;

    /**
     * 关闭csrf
     *
     * @var bool
     */
    public $enableCsrfValidation = false;
}