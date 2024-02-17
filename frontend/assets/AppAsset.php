<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yiiframe\adminlte\AdminLetAsset;
/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $sourcePath = '@webroot/resources';
    public $css = [
        'css/yiiframe.css',
    ];
    public $js = [
    ];
    public $depends = [
        AdminLetAsset::class,
    ];
}
