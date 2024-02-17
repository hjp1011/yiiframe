<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use api\controllers\OnAuthController;
use common\enums\StatusEnum;
use common\helpers\EchantsHelper;
use common\helpers\ResultHelper;
use common\models\rbac\AuthItemChild;

/**
 * 会员接口
 */
class MemberController extends OnAuthController
{

    public $modelClass = '';
    /**
     * 个人中心
     */
    public function actionIndex()
    {
        $id = Yii::$app->user->identity->member_id;
        if (Yii::$app->services->devPattern->isGroup())
            $model = \addons\Merchants\common\models\Member::class;
        else if (Yii::$app->services->devPattern->isEnterprise())
            $model = \common\models\backend\Member::class;
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            $model = \addons\Member\common\models\Member::class;

        $member = $model::find()->alias('m')
            ->where(['m.id' => $id])
            ->with(['assignment'])
//            ->with(['merchant','assignment','department'])
            ->joinWith(['role'])
            ->asArray()
            ->one();

        return $member;
    }

    /**
     * 更新
     *
     * @param $id
     * @return bool|mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->attributes = Yii::$app->request->post();
        if (!$model->save()) {
            return ResultHelper::json(422, $this->getError($model));
        }
        //避免返回敏感信息
        return ResultHelper::json(200, 'OK');
    }
    /**
     * 单个显示
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (Yii::$app->services->devPattern->isGroup())
            $model = \addons\Merchants\common\models\Member::class;
        else if (Yii::$app->services->devPattern->isEnterprise())
            $model = \common\models\backend\Member::class;
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            $model = \addons\Member\common\models\Member::class;
        $member = $model::find()
            ->where(['id' => $id, 'status' => StatusEnum::ENABLED])
            ->select([
                'id', 'username', 'nickname',
                'realname', 'head_portrait', 'gender',
                'qq', 'email', 'birthday',
                'user_money', 'user_integral', 'status',
                'created_at'
            ])
            ->asArray()
            ->one();

        if (!$member) {
            throw new NotFoundHttpException('请求的数据不存在或您的权限不足.');
        }

        return $member;
    }
    
    //个人信息授权
    public function actionPersonal()
    {
        $settings = [
            [
                'title' => '个人资料',
                'url' => '/pages/user/userinfo',
                'route' => '/merchants/base/member/personal',
                'content' => ''
            ],
            [
                'title' => '修改密码',
                'url' => '/pages/public/password?type=1',
                'route' => '/merchants/base/member/up-password',
                'content' => ''
            ],
            [
                'title' => '清除缓存',
                'url' => 'clearCache',
                'route' => '/main/clear-cache',
                'content' => ''
            ],
        ];

        $AuthItems = AuthItemChild::find()
                ->select('name')
                ->where(['app_id'=>'merchant','role_id'=>Yii::$app->user->identity->role_id])
                ->asArray()
                ->all();
        $items = [];
        foreach ($AuthItems as $key => $item) {
            $items[] = $item['name'];
        }
        $menu = [];
        $sign = 0;
        foreach ($settings as $key => $setting) {
            if(in_array($setting['route'], $items)){
                $menu[] = $setting;
                if($setting['route']=='/merchants/base/member/personal')
                $sign = 1;
            }
            
        }
        $list['menu'] = $menu;
        $list['sign'] = $sign;
        return $list;
    }
    protected function findModel($id)
    {
        if (Yii::$app->services->devPattern->isGroup())
            $model = \addons\Merchants\common\models\Member::class;
        else if (Yii::$app->services->devPattern->isEnterprise())
            $model = \common\models\backend\Member::class;
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            $model = \addons\Member\common\models\Member::class;

        if (empty($id) || !($member = $model::find()->where([
                'id' => $id,
                'status' => StatusEnum::ENABLED,
            ])->andFilterWhere(['merchant_id' => $this->getMerchantId()])->one())) {
            throw new NotFoundHttpException('请求的数据不存在');
        }

        return $member;
    }
    /**
     * 权限验证
     *
     * @param string $action 当前的方法
     * @param null $model 当前的模型类
     * @param array $params $_GET变量
     * @throws \yii\web\BadRequestHttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        // 方法名称
        if (in_array($action, ['delete'])) {
            throw new \yii\web\BadRequestHttpException('权限不足');
        }
    }
}
