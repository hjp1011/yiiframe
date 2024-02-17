<?php

namespace api\modules\v1\controllers;

use Yii;
use common\enums\StatusEnum;
use common\helpers\ResultHelper;
use addons\Member\common\models\Auth;
use api\controllers\UserAuthController;

/**
 * Class AuthController
 * @package addons\TinyShop\api\modules\v1\controllers\member
 * @author YiiFrame <21931118@qq.com>
 */
class AuthController extends UserAuthController
{
    /**
     * 不用进行登录验证的方法
     * 例如： ['index', 'update', 'create', 'view', 'delete']
     * 默认全部需要验证
     *
     * @var array
     */
    protected $authOptional = ['binding-equipment'];

    /**
     * 绑定设备进行 app 推送
     */
    public function actionBindingEquipment()
    {
        $oauthClient = Yii::$app->request->post('oauth_client');
        $oauthClientUserId = Yii::$app->request->post('oauth_client_user_id');
        $token = Yii::$app->request->post('token');
        if (!in_array($oauthClient, ['ios', 'android'])) {
            return false;
        }

        if (!$token || !($apiAccessToken = Yii::$app->services->apiAccessToken->findByAccessToken($token))) {
            return false;
        }

        /** @var Auth $model */
        if (!($model = Yii::$app->memberService->memberAuth->findOauthClientByApp($oauthClient, $oauthClientUserId))) {
            $model = new $this->modelClass();
            $model = $model->loadDefaultValues();
            $model->attributes = Yii::$app->request->post();
        }

        $model->oauth_client = $oauthClient;
        $model->oauth_client_user_id = $oauthClientUserId;
        $model->member_id = $apiAccessToken->member_id;
        $model->status = StatusEnum::DISABLED;
        if (!$model->save()) {
            return ResultHelper::json(422, $this->getError($model));
        }

        return $model;
    }
}