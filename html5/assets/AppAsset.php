<?php

namespace html5\assets;

use yii\web\AssetBundle;
use yiiframe\adminlte\AdminLetAsset;
/**
 * Class AppAsset
 * @package html5\assets
 * @author yiiframe <21931118@qq.com>
 */
class AppAsset extends AssetBundle
{
    
    public $sourcePath = '@webroot/resources';

    public $css = [
        // 'css/yiiframe.css',
    ];

    public $js = [
        // 'js/yiiframe.js',
    ];

    public $depends = [
        AdminLetAsset::class,
        
    ];
   
}
