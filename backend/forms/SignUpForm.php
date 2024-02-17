<?php

namespace backend\forms;

use common\enums\AppEnum;
use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use common\enums\MerchantStateEnum;
use common\enums\StatusEnum;
use common\enums\WhetherEnum;
use addons\Member\common\models\Member;

/**
 * Class SignUpForm
 * @package merchant\forms
 * @author YiiFrame <21931118@qq.com>
 */
class SignUpForm extends Model
{
    public $id;
    public $username;
    public $realname;
    public $mobile;
    public $password;
    public $password_repetition;
    public $rememberMe;
    public $group;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['rememberMe'], 'isRequired'],
            [['realname','mobile', 'password', 'password_repetition'], 'required'],
            [['mobile','realname','group'], 'string', 'min' => 2, 'max' => 15],
            [
                'mobile',
                'unique',
                'targetClass' => Member::class,
                'filter' => function (ActiveQuery $query) {
                    return $query->andWhere(['>=', 'status', StatusEnum::DISABLED]);
                },
                'message' => '该手机号码已经被占用.'
            ],
            ['mobile', 'match', 'pattern' => '/^1[3456789]\d{9}$/', 'message' => '手机号码格式不正确'],
            [
                ['username'],
                'unique',
                'targetClass' => Member::class,
                'filter' => function (ActiveQuery $query) {
                    return $query->andWhere(['>=', 'status', StatusEnum::DISABLED]);
                },
                'message' => '该用户名已经被占用了.'
            ],
//            ['username', 'match', 'pattern' => '/^1[3456789]\d{9}$/', 'message' => '手机号码格式不正确'],
//            [
//                'username',
//                'match',
//                'pattern' => '/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u',
//                'message' => '用户名由字母，汉字，数字，下划线组成，且不能以数字和下划线开头。',
//            ],
//            ['username', 'string', 'min' => 6, 'max' => 20],
            [['password', 'password_repetition'], 'string', 'min' => 6, 'max' => 20],
            //[['password'], 'match', 'pattern' => '/^.*(?=.{6,})(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*? ]).*$/','message'=>'请修改密码，密码必须包含大小写字母数字和特殊字符'],
            ['password_repetition', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入的密码不一致'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => '账号',
            'realname' => '姓名',
            'mobile' => '手机号码',
            'password' => '账户密码',
            'password_repetition' => '确认密码',
            'rememberMe' => '',
        ];
    }

    /**
     * @param $attribute
     */
    public function isRequired($attribute)
    {
        if (empty($this->rememberMe)) {
            $this->addError($attribute, '请同意用户协议');
        }
    }

    /**
     * @return bool|Merchant
     */
    public function register()
    {
        // 事务
        $transaction = Yii::$app->db->beginTransaction();
        try {
            
            //创建会员
            $member = new Member();
            $member->mobile = $this->mobile;
            $member->realname = $this->realname;
            $member->password_hash = Yii::$app->security->generatePasswordHash($this->password);

            if (!$member->save()) {
                $this->addErrors($member->getErrors());
                throw new NotFoundHttpException('用户信息编辑错误');
            }

            $transaction->commit();

            return $member;
        } catch (\Exception $e) {
            $transaction->rollBack();

            return false;
        }
    }
}