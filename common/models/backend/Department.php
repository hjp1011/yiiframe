<?php

namespace common\models\backend;
use Yii;
use common\traits\Tree;

class Department extends \common\models\base\BaseModel
{
    use Tree;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%backend_department}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['merchant_id','sort', 'level', 'pid', 'index_block_status', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['cover'], 'string', 'max' => 255],
            [['tree'], 'string'],
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
            'title' => Yii::t('app', '机构名称'),
            'cover' => Yii::t('app', '封面'),
            'sort' => Yii::t('app', '排序'),
            'level' => Yii::t('app', '级别'),
            'tree' => Yii::t('app', '树'),
            'pid' => Yii::t('app', '父级'),
            'index_block_status' => Yii::t('app', '显示'),
            'status' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }
}
