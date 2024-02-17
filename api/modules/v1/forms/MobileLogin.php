<?php

namespace api\modules\v1\forms;

use Yii;
use yii\base\Model;
use common\enums\StatusEnum;
use common\helpers\RegularHelper;
use common\enums\AccessTokenGroupEnum;
use addons\Alisms\common\models\SmsLog;

/**
 * Class MobileLogin
 */
class MobileLogin extends Model
{
    /**
     * @var
     */
    public $mobile;

    /**
     * @var
     */
    public $code;

    /**
     * @var
     */
    public $group;

    /**
     * @var
     */
    protected $_user;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['mobile', 'code', 'group'], 'required'],
            ['code', '\addons\Alisms\common\models\validators\SmsCodeValidator', 'usage' => SmsLog::USAGE_LOGIN],
            ['code', 'filter', 'filter' => 'trim'],
            ['mobile', 'match', 'pattern' => RegularHelper::mobile(), 'message' => '请输入正确的手机号'],
            ['mobile', 'validateMobile'],
            ['group', 'in', 'range' => AccessTokenGroupEnum::getKeys()]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'mobile' => '手机号码',
            'code' => '验证码',
            'group' => '组别',
        ];
    }

    /**
     * @param $attribute
     */
    public function validateMobile($attribute)
    {
        if (!$this->getUser()) {
            $this->addError($attribute, '找不到用户');
        }
    }

    /**
     * 获取用户信息
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