<?php

namespace common\enums;

/**
 * Class MethodEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class MethodEnum extends BaseEnum
{
    const POST = 'POST';
    const GET = 'GET';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const ALL = '*';

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::ALL => '不限',
            self::POST => 'Post',
            self::GET => 'Get',
            self::PUT => 'Put',
            self::DELETE => 'Delete',
        ];
    }
}