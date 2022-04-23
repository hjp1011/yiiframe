<?php

namespace common\enums;

/**
 * Class ConfigTypeEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class ConfigTypeEnum extends BaseEnum
{
    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            'text' => \Yii::t('app', '文本框'),
            'password' => \Yii::t('app', '密码框'),
            'secretKeyText' => \Yii::t('app', '密钥文本框'),
            'textarea' => \Yii::t('app', '文本域'),
            'date' => \Yii::t('app', '日期'),
            'time' => \Yii::t('app', '时间'),
            'datetime' => \Yii::t('app', '日期时间'),
            'dropDownList' => \Yii::t('app', '下拉框'),
            'multipleInput' => \Yii::t('app', 'Input组'),
            'radioList' => \Yii::t('app', '单选按钮'),
            'checkboxList' => \Yii::t('app', '复选框'),
            'baiduUEditor' => \Yii::t('app', '百度编辑器'),
            'image' => \Yii::t('app', '图片上传'),
            'images' => \Yii::t('app', '多图上传'),
            'file' => \Yii::t('app', '文件上传'),
            'files' => \Yii::t('app', '多文件上传'),
            'cropper' => \Yii::t('app', '裁剪上传'),
            'latLngSelection' => \Yii::t('app', '经纬度选择'),
        ];
    }
}