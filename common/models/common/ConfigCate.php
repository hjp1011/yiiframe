<?php

namespace common\models\common;
use Yii;
use common\traits\Tree;
use common\enums\StatusEnum;

/**
 * This is the model class for table "{{%common_config_cate}}".
 *
 * @property int $id 主键
 * @property string $title 标题
 * @property string $pid 上级id
 * @property int $level 级别
 * @property int $sort 排序
 * @property string $tree 树
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property string $created_at 添加时间
 * @property string $updated_at 修改时间
 */
class ConfigCate extends \common\models\base\BaseModel
{
    use Tree;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%common_config_cate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'sort'], 'required'],
            [['pid', 'level', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 50],
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
            'title' => Yii::t('app', '标题'),
            'pid' => Yii::t('app', '父级'),
            'app_id' => Yii::t('app', '应用'),
            'level' => Yii::t('app', '级别'),
            'sort' => Yii::t('app', '排序'),
            'tree' => Yii::t('app', '树'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfig()
    {
        return $this->hasMany(Config::class, ['cate_id' => 'id'])
            ->where(['status' => StatusEnum::ENABLED])
            ->orderBy('sort asc');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'pid']);
    }
}
