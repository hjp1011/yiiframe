<?php

namespace common\enums;

use common\enums\BaseEnum;

/**
 * Class TypeEnum
 * @package addons\TinyService\common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class TypeEnum extends BaseEnum
{
    const MEMBER = 'member';
    const MERCHANT = 'merchant';
    const BACKEND = 'backend';

    public static function getMap(): array
    {
        return [
            self::MEMBER => '用户',
            self::BACKEND => '平台客服',
            self::MERCHANT => '企业客服',
        ];
    }

    /**
     * @param $value
     * @return string
     */
    public static function html($value)
    {
        $text = self::getValue($value);
        if ($value == self::MEMBER) {
            return "<small class='purple'>{$text}</small>";
        }

        if ($value == self::MERCHANT) {
            return " <small class='cyan'>{$text}</small>";
        }

        if ($value == self::BACKEND) {
            return " <small class='cyan'>{$text}</small>";
        }
    }
}