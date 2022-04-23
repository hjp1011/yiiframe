<?php

namespace common\enums;

/**
 * 企业状态
 *
 * Class MerchantStateEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class MerchantStateEnum extends BaseEnum
{
    const ENABLED = 1;
    const DISABLED = 0;
    const AUDIT = 2;

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::ENABLED => '开启',
            self::DISABLED => '关闭',
            // self::AUDIT => '审核中',
        ];
    }
}