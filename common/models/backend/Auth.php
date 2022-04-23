<?php

namespace common\models\backend;

use Yii;
use common\enums\StatusEnum;

/**
 * This is the model class for table "{{%backend_member_auth}}".
 *
 * @property string $id 主键
 * @property string $member_id 用户id
 * @property string $unionid 唯一ID
 * @property string $oauth_client 授权组别
 * @property string $oauth_client_user_id 授权id
 * @property int $gender 性别[0:未知;1:男;2:女]
 * @property string $nickname 昵称
 * @property string $head_portrait 头像
 * @property string $birthday 生日
 * @property string $country 国家
 * @property string $province 省
 * @property string $city 市
 * @property int $status 状态(-1:已删除,0:禁用,1:正常)
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 */
class Auth extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%backend_member_auth}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oauth_client', 'oauth_client_user_id'], 'required'],
            [['member_id', 'gender', 'status', 'created_at', 'updated_at'], 'integer'],
            [['birthday'], 'safe'],
            [['unionid'], 'string', 'max' => 64],
            [['oauth_client'], 'string', 'max' => 20],
            [['oauth_client_user_id', 'nickname', 'country', 'province', 'city'], 'string', 'max' => 100],
            [['head_portrait'], 'string', 'max' => 150],
            ['member_id', 'isBinding']
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
            'unionid' => '第三方用户唯一id',
            'oauth_client' => '类型',
            'oauth_client_user_id' => '第三方用户id',
            'gender' => Yii::t('app', '性别'),
            'nickname' => Yii::t('app', '昵称'),
            'head_portrait' => Yii::t('app', '头像'),
            'birthday' => Yii::t('app', '生日'),
            'country' => Yii::t('app', '国家'),
            'province' => Yii::t('app', '省'),
            'city' => Yii::t('app', '市'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * 验证绑定
     *
     * @param $attribute
     */
    public function isBinding($attribute)
    {
        $model = self::find()
            ->where([
                'member_id' => $this->member_id,
                'oauth_client_user_id' => $this->oauth_client_user_id,
                'status' => StatusEnum::ENABLED,
            ])
            ->one();

        if ($model && $model->id != $this->id) {
            $this->addError($attribute, '用户已绑定请不要重复绑定');
        }
    }

    /**
     * 关联用户
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(\common\models\backend\Member::class, ['id' => 'member_id']);
    }
}
