<?php

namespace common\enums;

/**
 * Class WhetherEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class WhetherEnum extends BaseEnum
{
    const ENABLED = 1;
    const DISABLED = 0;

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::ENABLED => \Yii::t('app', '是'),
            self::DISABLED => \Yii::t('app', '否'),
        ];
    }
}