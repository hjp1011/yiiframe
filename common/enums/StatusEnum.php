<?php

namespace common\enums;
use Yii;
/**
 * 状态枚举
 *
 * Class StatusEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class StatusEnum extends BaseEnum
{
    const ENABLED = 1;
    const DISABLED = 0;
    const DELETE = -1;

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::ENABLED => Yii::t('app','启用'),
            self::DISABLED => Yii::t('app','禁用'),
//            self::DELETE => Yii::t('app','销毁'),
        ];
    }
}