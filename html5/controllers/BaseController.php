<?php

namespace html5\controllers;

use Yii;
use yii\web\Controller;
use addons\Weixin\common\traits\WechatLogin;
use common\traits\BaseAction;

/**
 * 微信基类
 *
 * Class BaseController
 * @package wechat\controllers
 * @author yiiframe <21931118@qq.com>
 */
class BaseController extends Controller
{
    // use WechatLogin, BaseAction;
    use BaseAction;
    
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {

        parent::init();
        // if (!Yii::$app->wechat->isWechat) {
            // die('请用微信打开');
        // }

        // 修改微信授权方式为静默授权
        // Yii::$app->params['wechatConfig']['oauth']['scopes'] = ['snsapi_base'];

        // 强制开启微信模拟数据
        // Yii::$app->params['simulateUser']['switch'] = true;
        // 微信登录
        // $this->login();
    }
}
