<?php

namespace api\modules\v1\forms;
use Yii;
use yii\base\Model;
use common\helpers\RegularHelper;
use common\enums\AccessTokenGroupEnum;
use addons\Alisms\common\models\validators\SmsCodeValidator;
use addons\Alisms\common\models\SmsLog;

/**
 * Class RegisterForm
 */
class RegisterForm extends Model
{
    public $mobile;
    public $password;
    public $password_repetition;
    public $code;
    public $group;
    public $realname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        if (Yii::$app->services->devPattern->isGroup())
            $Member =  \addons\Merchants\common\models\Member::class;
        else if (Yii::$app->services->devPattern->isEnterprise())
            $Member =  \common\models\backend\Member::class;
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            $Member =  \addons\Member\common\models\Member::class;
        return [
            [['mobile', 'group', 'code', 'password', 'password_repetition', 'realname'], 'required'],
            [['realname'], 'string'],
            [['password'], 'string', 'min' => 6],
            [
                ['mobile'],
                'unique',
                'targetClass' => $Member,
                'targetAttribute' => 'mobile',
                'message' => '此{attribute}已存在。'
            ],
            ['code', SmsCodeValidator::class, 'usage' => SmsLog::USAGE_REGISTER],
            ['mobile', 'match', 'pattern' => RegularHelper::mobile(), 'message' => '请输入正确的手机号码'],
            [['password_repetition'], 'compare', 'compareAttribute' => 'password'],// 验证新密码和重复密码是否相等
            ['group', 'in', 'range' => AccessTokenGroupEnum::getKeys()],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mobile' => '手机号码',
            'realname' => '姓名',
            'password' => '密码',
            'password_repetition' => '重复密码',
            'group' => '类型',
            'code' => '验证码',
        ];
    }
}