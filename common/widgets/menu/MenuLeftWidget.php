<?php

namespace common\widgets\menu;

use Yii;
use yii\base\Widget;
use yiiframe\plugs\services\AddonsService;

/**
 * 左边菜单
 *
 * Class MenuLeftWidget
 * @package common\widgets\menu
 * @author YiiFrame <21931118@qq.com>
 */
class MenuLeftWidget extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        return $this->render('menu-left', [
            'menus' => Yii::$app->services->menu->getOnAuthList(),
            'addonsMenus' => AddonsService::getMenus(),
        ]);
    }
}