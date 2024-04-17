<?php

namespace common\components\gii\crud;

use Yii;

/**
 * Class Generator
 * @package backend\components\gii\crud
 * @author YiiFrame <21931118@qq.com>
 */
class Generator extends \yiiframe\gii\generators\crud\Generator
{
    public $listFields;
    public $formFields;
    public $inputType;

    /**
     * @return array
     */
    public function fieldTypes()
    {
        return [
            'text' => Yii::t('app','文本框'),
            'textarea' => Yii::t('app','文本域'),
            'time' => Yii::t('app','时间'),
            'date' => Yii::t('app','日期'),
            'datetime' => Yii::t('app','日期时间'),
            'color' => Yii::t('app','颜色'),
            'dropDownList' => Yii::t('app','下拉框'),
            'multipleInput' => Yii::t('app','Input组'),
            'radioList' => Yii::t('app','单选按钮'),
            'checkboxList' => Yii::t('app','复选框'),
            'baiduUEditor' => Yii::t('app','百度编辑器'),
            'image' => Yii::t('app','图片上传'),
            'images' => Yii::t('app','多图上传'),
            'file' => Yii::t('app','文件上传'),
            'files' => Yii::t('app','多文件上传'),
            'cropper' => Yii::t('app','裁剪上传'),
            'latLngSelection' => Yii::t('app','经纬度选择'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['listFields', 'formFields', 'inputType'], 'safe'],
        ]);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'listFields' => Yii::t('app', '列表字段'),
        ];
    }
    /**
     * Generates code for active field
     * @param string $attribute
     * @return string
     */
    public function generateActiveField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        $type = $this->inputType[$attribute] ?? '';

        switch ($type) {
            case 'text':
                return parent::generateActiveField($attribute);
                break;
            case 'textarea':
                return "\$form->field(\$model, '$attribute')->textarea()";
                break;
            case 'dropDownList':
                case 'dropDownList':
                return "\$form->field(\$model, '$attribute')->dropDownList(['1'=>'下拉选项1','2'=>'下拉选项2','3'=>'下拉选项3'],['prompt' => Yii::t('app','请选择')])";
                break;
            case 'radioList':
                return "\$form->field(\$model, '$attribute')->radioList(['1'=>'选项1','2'=>'选项2','3'=>'选项3'])";
                break;
            case 'checkboxList':
                return "\$form->field(\$model, '$attribute')->checkboxList(['1'=>'选项1','2'=>'选项2','3'=>'选项3'])";
                break;
            case 'baiduUEditor':
                if (\yiiframe\plugs\common\AddonHelper::isInstall('Ueditor'))
                return "\$form->field(\$model, '$attribute')->widget(\addons\Ueditor\common\widgets\ueditor\UEditor::class, [])";
                else 
                return "\$form->field(\$model, '$attribute')->textarea()";
                break;
            case 'color':
                return "\$form->field(\$model, '$attribute')->widget(\kartik\color\ColorInput::class, [
                            'options' => ['placeholder' => '请选择颜色'],
                    ]);";
                break;
            case 'time':
                return "\$form->field(\$model, '$attribute')->widget(kartik\\time\TimePicker::class, [
                        'language' => 'zh-CN',
                        'pluginOptions' => [
                            'showSeconds' => true
                        ]
                    ])";
                break;
            case 'date':
                return "\$form->field(\$model, '$attribute')->widget(kartik\date\DatePicker::class, [
                        'language' => 'zh-CN',
                        'layout'=>'{picker}{input}',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true, // 今日高亮
                            'autoclose' => true, // 选择后自动关闭
                            'todayBtn' => true, // 今日按钮显示
                        ],
                        'options'=>[
                            'class' => 'form-control no_bor',
                        ]
                    ])";
                break;
            case 'datetime':
                return "\$form->field(\$model, '$attribute')->widget(kartik\datetime\DateTimePicker::class, [
                        'language' => 'zh-CN',
                        'options' => [
                            'value' => \$model->isNewRecord ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s',\$model->$attribute),
                        ],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd hh:ii',
                            'todayHighlight' => true, // 今日高亮
                            'autoclose' => true, // 选择后自动关闭
                            'todayBtn' => true, // 今日按钮显示
                        ]
                    ])";
                break;
            case 'multipleInput':
                return "\$form->field(\$model, '$attribute')->widget(unclead\multipleinput\MultipleInput::class, [
                        'max' => 4,
                        'columns' => [
                            [
                                'name'  => 'user_id',
                                'type'  => 'dropDownList',
                                'title' => 'User',
                                'defaultValue' => 1,
                                'items' => [
                                   1 => 'User 1',
                                    2 => 'User 2'
                                ]
                            ],
                            [
                                'name'  => 'day',
                                'type'  => \kartik\date\DatePicker::class,
                                'title' => 'Day',
                                'value' => function(\$data) {
                                    return \$data['day'];
                                },
                                'items' => [
                                    '0' => 'Saturday',
                                    '1' => 'Monday'
                                ],
                                'options' => [
                                    'pluginOptions' => [
                                        'format' => 'dd.mm.yyyy',
                                        'todayHighlight' => true
                                    ]
                                ]
                            ],
                            [
                                'name'  => 'priority',
                                'title' => 'Priority',
                                'enableError' => true,
                                'options' => [
                                    'class' => 'input-priority'
                                ]
                            ]
                        ]
                     ])";
                break;
            case 'cropper':
                if (\yiiframe\plugs\common\AddonHelper::isInstall('Webuploader')&&\yiiframe\plugs\common\AddonHelper::isInstall('Cropper'))
                return "\$form->field(\$model, '$attribute')->widget(\addons\Cropper\common\widgets\cropper\Cropper::class, [
                            'config' => [
                                  // 可设置自己的上传地址, 不设置则默认地址
                                  // 'server' => '',
                             ],
                            'formData' => [
                                // 'drive' => 'local',// 默认本地 支持 qiniu/oss/cos 上传
                            ],
                    ]);";
                else
                return "\$form->field(\$model, '$attribute')->textInput()";
                break;
            case 'latLngSelection':
                return "\$form->field(\$model, '$attribute')->widget(\addons\Map\common\widgets\selectmap\Map::class, [
                            'type' => 'amap', // amap高德;tencent:腾讯;baidu:百度
                    ])->hint('点击地图某处才会获取到经纬度，否则默认北京')";
                break;
            case 'image':
                if (\yiiframe\plugs\common\AddonHelper::isInstall('Webuploader'))
                return "\$form->field(\$model, '$attribute')->widget(\addons\Webuploader\common\widgets\webuploader\Files::class, [
                            'type' => 'images',
                            'theme' => 'default',
                            'themeConfig' => [],
                            'config' => [
                                // 可设置自己的上传地址, 不设置则默认地址
                                // 'server' => '',
                                'pick' => [
                                    'multiple' => false,
                                ],
                            ]
                    ])->label(Yii::t('app','图片上传'));";
                else
                return "\$form->field(\$model, '$attribute')->textInput()";
                break;
            case 'images':
                if (\yiiframe\plugs\common\AddonHelper::isInstall('Webuploader'))
                return "\$form->field(\$model, '$attribute')->widget(\addons\Webuploader\common\widgets\webuploader\Files::class, [
                            'type' => 'images',
                            'theme' => 'default',
                            'themeConfig' => [],
                            'config' => [
                                // 可设置自己的上传地址, 不设置则默认地址
                                // 'server' => '',
                                'pick' => [
                                    'multiple' => true,
                                ],
                            ]
                    ])->label(Yii::t('app','多图上传'));";
                else
                return "\$form->field(\$model, '$attribute')->textInput()";
                break;
            case 'file':
                if (\yiiframe\plugs\common\AddonHelper::isInstall('Webuploader'))
                return "\$form->field(\$model, '$attribute')->widget(\addons\Webuploader\common\widgets\webuploader\Files::class, [
                            'type' => 'files',
                            'theme' => 'default',
                            'themeConfig' => [],
                            'config' => [
                                // 可设置自己的上传地址, 不设置则默认地址
                                // 'server' => '',
                                'pick' => [
                                    'multiple' => false,
                                ],
                            ]
                    ])->label(Yii::t('app','文件上传'));";
                else
                return "\$form->field(\$model, '$attribute')->textInput()";
                break;
            case 'files':
                if (\yiiframe\plugs\common\AddonHelper::isInstall('Webuploader'))
                return "\$form->field(\$model, '$attribute')->widget(\addons\Webuploader\common\widgets\webuploader\Files::class, [
                            'type' => 'files',
                            'theme' => 'default',
                            'themeConfig' => [],
                            'config' => [
                                // 可设置自己的上传地址, 不设置则默认地址
                                // 'server' => '',
                                'pick' => [
                                    'multiple' => true,
                                ],
                            ]
                    ])->label(Yii::t('app','多文件上传'));";
                else
                return "\$form->field(\$model, '$attribute')->textInput()";
                break;
        }
    }
}