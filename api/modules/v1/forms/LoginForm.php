<?php

namespace api\modules\v1\forms;
use Yii;
use common\enums\StatusEnum;
use common\enums\AccessTokenGroupEnum;

/**
 * Class LoginForm
 */
class LoginForm extends \common\models\forms\LoginForm
{
    public $group;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'password', 'group'], 'required'],
            ['password', 'validatePassword'],
            ['group', 'in', 'range' => AccessTokenGroupEnum::getKeys()]
        ];
    }

    public function attributeLabels()
    {
        return [
            'mobile' => '登录帐号',
            'password' => '登录密码',
            'group' => '组别',
        ];
    }

    /**
     * 用户登录
     *
     * @return mixed|null|static
     */
    public function getUser()
    {
        if ($this->_user == false) {

            if (Yii::$app->services->devPattern->isGroup())
                $this->_user = \addons\Merchants\common\models\Member::findOne(['mobile' => $this->mobile, 'status' => StatusEnum::ENABLED]);
            else if (Yii::$app->services->devPattern->isEnterprise())
                $this->_user = \common\models\backend\Member::findOne(['mobile' => $this->mobile, 'status' => StatusEnum::ENABLED]);
            else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
                $this->_user = \addons\Member\common\models\Member::findOne(['mobile' => $this->mobile, 'status' => StatusEnum::ENABLED]);


        }

        return $this->_user;
    }
}
