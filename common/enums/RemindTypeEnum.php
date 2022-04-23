<?php

namespace common\enums;

use common\enums\BaseEnum;
/**
 * 枚举
 *
 * Class GenderEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class RemindTypeEnum extends BaseEnum
{
    const sms = 0;
    const message = 1;
    const normal = 2;

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::sms => \Yii::t('app','短信'),
            self::message => \Yii::t('app','消息'),
            self::normal => \Yii::t('app','无提醒'),

        ];
    }

    public static function getValue($key): string
    {
        return static::getMap()[$key] ?? '';
    }
}