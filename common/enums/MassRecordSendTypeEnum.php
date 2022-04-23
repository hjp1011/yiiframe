<?php

namespace common\enums;

/**
 * Class MassRecordSendTypeEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class MassRecordSendTypeEnum extends BaseEnum
{
    const AT_ONCE = 1;
    const TIMING = 2;
    const TEST = 3;

    /**
     * @return array|string[]
     */
    public static function getMap(): array
    {
        return [
            self::AT_ONCE => '立即发送',
            self::TIMING => '定时发送',
            self::TEST => '测试发送',
        ];
    }
}