<?php

namespace common\enums;

/**
 * 性别枚举
 *
 * Class GenderEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class GenderEnum extends BaseEnum
{
    const UNKNOWN = 0;
    const MAN = 1;
    const WOMAN = 2;

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::UNKNOWN => \Yii::t('app', '男'),
            self::MAN => \Yii::t('app', '女'),
            self::WOMAN => \Yii::t('app', '保密'),
        ];
    }
}