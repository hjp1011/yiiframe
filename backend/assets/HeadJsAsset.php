<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class HeadJsAsset
 * @package backend\assets
 * @author YiiFrame <21931118@qq.com>
 */
class HeadJsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/resources';

    public $js = [
        
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
}