<?php

namespace common\models\rbac;

use Yii;
use common\traits\Tree;

/**
 * This is the model class for table "rf_rbac_auth_role".
 *
 * @property int $id 主键
 * @property int $merchant_id 企业id
 * @property string $title 标题
 * @property string $app_id 应用
 * @property int $pid 上级id
 * @property int $level 级别
 * @property int $sort 排序
 * @property string $tree 树
 * @property int $is_default 是否默认角色
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property int $created_at 添加时间
 * @property int $updated_at 修改时间
 */
class AuthRole extends \common\models\base\BaseModel
{
    use Tree;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rbac_auth_role}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'trim'],
            [['title', 'pid'], 'required'],
            [['title'], 'isUniquTitle'],
            [['merchant_id', 'pid', 'is_default', 'level', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['app_id'], 'string', 'max' => 20],
            [['tree'], 'string', 'max' => 300],
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
            'title' => Yii::t('app', '角色'),
            'app_id' => Yii::t('app', '应用'),
            'sort' => Yii::t('app', '排序'),
            'level' => Yii::t('app', '级别'),
            'pid' => Yii::t('app', '父级'),
            'tree' => Yii::t('app', '树'),
            'is_default' => Yii::t('app', '默认'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * @param $attribute
     */
    public function isUniquTitle($attribute)
    {
        $merchant_id = $this->merchant_id;
        !$merchant_id && $merchant_id = Yii::$app->services->merchant->getId();

        $model = self::find()->where([
            'merchant_id' => $merchant_id,
            'title' => $this->title
        ])->one();

        if ($model && $model->id != $this->id) {
            $this->addError($attribute, '角色名称已存在');
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChild()
    {
        return $this->hasMany(AuthItemChild::class, ['role_id' => 'id']);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        AuthItemChild::deleteAll(['role_id' => $this->id]);
        AuthAssignment::deleteAll(['role_id' => $this->id]);

        $this->autoDeleteTree();

        return parent::beforeDelete();
    }
}
