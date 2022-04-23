<?php

namespace common\enums;

/**
 * Class LogisticsTypeEnum
 * @package addons\TinyShop\common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class LogisticsTypeEnum extends BaseEnum
{
    const ALIYUN = 'aliyun';
    const JUHE = 'juhe';
    const KDNIAO = 'kdniao';
    const KD100 = 'kd100';
    const RUIJIE = 'ruijie';

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::ALIYUN => '阿里云',
            self::JUHE => '聚合',
            self::KDNIAO => '快递鸟',
            self::KD100 => '快递100',
            // self::RUIJIE => '锐界',

        ];
    }
}