<?php

namespace common\models\backend;


use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\enums\AppEnum;
use common\models\base\User;
use common\enums\MemberAuthEnum;
use common\enums\StatusEnum;
use common\models\rbac\AuthAssignment;
use common\models\rbac\AuthRole;
use common\models\backend\Auth;
use common\models\backend\Department;
use common\helpers\StringHelper;
//use addons\Merchants\common\models\Merchant;

/**
 * This is the model class for table "{{%backend_member}}".
 *
 * @property int $id
 * @property string $merchant_id 企业id
 * @property string $username 帐号
 * @property string $password_hash 密码
 * @property string $auth_key 授权令牌
 * @property string $password_reset_token 密码重置令牌
 * @property int $type 1:普通管理员;10超级管理员
 * @property string $realname 真实姓名
 * @property string $head_portrait 头像
 * @property int $gender 性别[0:未知;1:男;2:女]
 * @property string $qq qq
 * @property string $email 邮箱
 * @property string $birthday 生日
 * @property int $province_id 省
 * @property int $city_id 城市
 * @property int $area_id 地区
 * @property string $address 默认地址
 * @property string $mobile 手机号码
 * @property string $home_phone 家庭号码
 * @property string $dingtalk_robot_token 机器人token
 * @property int $visit_count 访问次数
 * @property int $last_time 最后一次登录时间
 * @property string $last_ip 最后一次登录ip
 * @property int $role 权限
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 */
class Member extends User
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%backend_member}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'gender', 'province_id', 'city_id', 'area_id', 'visit_count', 'last_time', 'role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['birthday'], 'safe'],
            [['username', 'qq', 'mobile', 'home_phone'], 'string', 'max' => 20],
            [['password_hash', 'password_reset_token', 'head_portrait'], 'string', 'max' => 150],
            [['auth_key'], 'string', 'max' => 32],
            [['realname'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 60],
            [['address'], 'string', 'max' => 100],
            [['dingtalk_robot_token'], 'string', 'max' => 200],
            [['last_ip'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'merchant_id' => Yii::t('app', '企业'),
            'department_id' => Yii::t('app', '机构'),
            'role_id' => Yii::t('app', '角色'),
            'username' => Yii::t('app', '账号'),
            'password_hash' => Yii::t('app', '密码'),
            'auth_key' => Yii::t('app', '授权密钥'),
            'password_reset_token' => Yii::t('app', '密码重置令牌'),
            'type' => Yii::t('app', '类型'),
            'realname' => Yii::t('app', '姓名'),
            'head_portrait' => Yii::t('app', '头像'),
            'gender' => Yii::t('app', '性别'),
            'qq' => Yii::t('app', 'QQ'),
            'email' => Yii::t('app', '邮箱'),
            'birthday' => Yii::t('app', '生日'),
            'province_id' => Yii::t('app', '省'),
            'city_id' => Yii::t('app', '市/县'),
            'area_id' => Yii::t('app', '地区'),
            'address' => Yii::t('app', '联系地址'),
            'mobile' => Yii::t('app', '手机'),
            'home_phone' => Yii::t('app', '电话'),
            'dingtalk_robot_token' => Yii::t('app', '钉钉机器人token'),
            'visit_count' => Yii::t('app', '访问次数'),
            'last_time' => Yii::t('app', '最后登录时间'),
            'last_ip' => Yii::t('app', '最后登录IP'),
            'role' => Yii::t('app', '权限'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }
    /**
     * 关联授权角色
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignment()
    {
        return $this->hasOne(AuthAssignment::class, ['user_id' => 'id'])->where(['app_id'=>AppEnum::BACKEND]);
    }
    public function getRole()
    {
        return $this->hasOne(AuthRole::class, ['id' => 'role_id']);
    }
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    /**
     * 关联第三方绑定
     */
    public function getAuth()
    {
        return $this->hasMany(Auth::class, ['member_id' => 'id'])->where(['status' => StatusEnum::ENABLED]);
    }
    /**
     * 关联微信第三方绑定
     */
    public function getAuthWechat()
    {
        return $this->hasOne(Auth::class, ['member_id' => 'id'])->where(['status' => StatusEnum::ENABLED, 'oauth_client' => MemberAuthEnum::WECHAT]);
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->auth_key = Yii::$app->security->generateRandomString();
        }

        return parent::beforeSave($insert);
    }
    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            if (empty($this->username) && !empty($this->mobile)) {
                $username = StringHelper::random(5) . '_' . substr($this->mobile, -4);
                $this->username = $username;
                Member::updateAll(['username' => $username], ['id' => $this->id]);
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }
    /**
     * @return bool
     */
    public function beforeDelete()
    {
        AuthAssignment::deleteAll(['user_id' => $this->id, 'app_id' => AppEnum::BACKEND]);
        return parent::beforeDelete();
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ]
        ];
    }
}
