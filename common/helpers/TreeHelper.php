<?php

namespace common\helpers;

/**
 * Class TreeHelper
 * @package common\helpers
 * @author YiiFrame <21931118@qq.com>
 */
class TreeHelper
{
    /**
     * @return string
     */
    public static function prefixTreeKey($id)
    {
        return "tr_$id ";
    }

    /**
     * @return string
     */
    public static function defaultTreeKey()
    {
        return 'tr_0 ';
    }
}