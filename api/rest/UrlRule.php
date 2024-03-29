<?php

namespace api\rest;

use Yii;
use yii\web\Request;
use yii\base\InvalidConfigException;
use common\helpers\StringHelper;
use yiiframe\plugs\services\AddonsService;

/**
 * Class UrlRule
 * @package api\rest
 * @author YiiFrame <21931118@qq.com>
 */
class UrlRule extends \yii\rest\UrlRule
{
    /**
     * @param $manager
     * @param $request Request
     * @throws InvalidConfigException if the path info cannot be determined due to unexpected server configuration
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        $path_info = $request->getPathInfo();
        $path_info_list = explode('/', $path_info);
        $names = [];
        $addons = AddonsService::findAllNames();
        foreach ($addons as $addon) {
            $names[] = StringHelper::toUnderScore($addon['name']);
        }

        if (count($path_info_list) >= 3 && in_array($path_info_list[0], $names)) {
            return [$path_info, []];
        }

        return false;
    }
}