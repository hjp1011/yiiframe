<?php

namespace api\modules\v1\forms;

use Yii;
use yii\base\Model;
use yii\web\UnauthorizedHttpException;
use common\models\api\AccessToken;
use common\enums\AccessTokenGroupEnum;

/**
 * Class RefreshForm
 */
class RefreshForm extends Model
{
    public $group;
    public $refresh_token;

    protected $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refresh_token', 'group'], 'required'],
            ['refresh_token', 'validateTime'],
            ['group', 'in', 'range' => AccessTokenGroupEnum::getKeys()]
        ];
    }

    public function attributeLabels()
    {
        return [
            'refresh_token' => '重置令牌',
            'group' => '组别',
        ];
    }

    /**
     * 验证过期时间
     *
     * @param $attribute
     * @throws UnauthorizedHttpException
     */
    public function validateTime($attribute)
    {
        if (!$this->hasErrors() && Yii::$app->params['user.refreshTokenValidity'] == true) {
            $token = $this->refresh_token;
            $timestamp = (int)substr($token, strrpos($token, '_') + 1);
            $expire = Yii::$app->params['user.refreshTokenExpire'];

            // 验证有效期
            if ($timestamp + $expire <= time()) {
                throw new UnauthorizedHttpException('您的重置令牌已经过期，请重新登录');
            }
        }

        if (!$this->getUser()) {
            throw new UnauthorizedHttpException('找不到用户');
        }
    }


    public function getUser()
    {
        if ($this->_user == false) {
            if (!($apiAccount = AccessToken::findIdentityByRefreshToken($this->refresh_token, $this->group))) {
                return false;
            }

            if (Yii::$app->services->devPattern->isGroup())
                $this->_user = \addons\Merchants\common\models\Member::findIdentity($apiAccount->member_id);
            else if (Yii::$app->services->devPattern->isEnterprise())
                $this->_user = \common\models\backend\Member::findIdentity($apiAccount->member_id);
            else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
                $this->_user = \addons\Member\common\models\Member::findIdentity($apiAccount->member_id);
        }

        return $this->_user;
    }
}