<?php

namespace common\enums;

/**
 * Class AppEnum
 * @package common\enums
 * @author YiiFrame <21931118@qq.com>
 */
class AppEnum extends BaseEnum
{
    const BACKEND = 'backend';
    const FRONTEND = 'frontend';
    const API = 'api';
    const HTML5 = 'html5';
    const MERCHANT = 'merchant';
    const MER_API = 'merapi';
    const OAUTH2 = 'oauth2';
    const STORAGE = 'storage';
    const CONSOLE = 'console';

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::BACKEND => \Yii::t('app','后台'),
            self::FRONTEND => \Yii::t('app','前台'),
            self::API => \Yii::t('app','接口'),
            self::HTML5 => \Yii::t('app','手机端'),
            self::MERCHANT => \Yii::t('app','企业端'),
            self::MER_API => \Yii::t('app','企业接口'),
            self::OAUTH2 => \Yii::t('app','Oauth2'),
            self::STORAGE => \Yii::t('app','存储'),
            self::CONSOLE => \Yii::t('app','控制台'),
        ];
    }

    /**
     * 接口
     *
     * @return array
     */
    public static function api()
    {
        return [self::API, self::MER_API, self::OAUTH2];
    }

    /**
     * 管理后台
     *
     * @return array
     */
    public static function admin()
    {
        return [self::BACKEND, self::MERCHANT];
    }
}