<?php

namespace common\enums;

/**
 * Class InvoiceTypeEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class InvoiceTypeEnum extends BaseEnum
{
    const COMPANY = 1;
    const PERSONAGE = 2;

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::COMPANY => '公司',
            self::PERSONAGE => '个人',
        ];
    }
}