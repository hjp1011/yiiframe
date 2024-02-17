<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yiiframe\adminlte\AdminLetAsset;
/**
 * Class AppAsset
 * @package backend\assets
 * @author YiiFrame <21931118@qq.com>
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/resources';

    public $css = [
        
        'css/yiiframe.css',
        'css/yiiframe.widgets.css',
    ];

    public $js = [
        
        'js/template.js',
        'js/yiiframe.js',
        'js/yiiframe.widgets.js',
    ];

    public $depends = [
        YiiAsset::class,
        AdminLetAsset::class,
        HeadJsAsset::class
    ];
}
