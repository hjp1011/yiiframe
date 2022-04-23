<?php

namespace common\enums;

/**
 * Class MessageLevelEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class MessageLevelEnum extends BaseEnum
{
    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            // self::SUCCESS => '成功',
            self::INFO => \Yii::t('addon','信息'),
            self::WARNING => \Yii::t('addon','警告'),
            self::ERROR => \Yii::t('addon','错误'),
        ];
    }
}