<?php

namespace common\models\common;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%common_config}}".
 *
 * @property string $id 主键
 * @property string $title 配置标题
 * @property string $name 配置标识
 * @property string $type 配置类型
 * @property string $cate_id 配置分类
 * @property string $extra 配置值
 * @property string $remark 配置说明
 * @property int $is_hide_remark 是否隐藏说明
 * @property string $default_value 默认配置
 * @property string $sort 排序
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 */
class Config extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%common_config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'name', 'type', 'cate_id', 'sort'], 'required'],
            [['cate_id', 'is_hide_remark', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'name'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 30],
            [['extra', 'remark'], 'string', 'max' => 1000],
            [['default_value'], 'string', 'max' => 500],
            [['name'], 'unique', 'filter' => function(ActiveQuery $query) {
                return $query->andWhere(['app_id' => $this->app_id]);
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '标题'),
            'name' => Yii::t('app', '标识'),
            'app_id' => Yii::t('app', '应用'),
            'type' => Yii::t('app', '类型'),
            'cate_id' => Yii::t('app', '分类'),
            'extra' => Yii::t('app', '配置项'),
            'remark' => Yii::t('app', '备注'),
            'is_hide_remark' => Yii::t('app', '隐藏'),
            'default_value' => Yii::t('app', '默认'),
            'sort' => Yii::t('app', '排序'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCate()
    {
        return $this->hasOne(ConfigCate::class, ['id' => 'cate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValue()
    {
        return $this->hasOne(ConfigValue::class, ['config_id' => 'id']);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        // 重新写入缓存
        Yii::$app->debris->backendConfigAll(true);

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return bool
     */
    public function afterDelete()
    {
        // 重新写入缓存
        Yii::$app->debris->backendConfigAll(true);
        // 移除关联内容
        ConfigValue::deleteAll(['config_id' => $this->id]);

        return parent::beforeDelete();
    }
}
