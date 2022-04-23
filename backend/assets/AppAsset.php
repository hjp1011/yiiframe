<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use common\widgets\adminlet\AdminLetAsset;

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
        'plugins/toastr/toastr.min.css', // 状态通知
        'plugins/fancybox/jquery.fancybox.min.css', // 图片查看
        'plugins/cropper/cropper.min.css',
        'css/yiiframe.css',
        'css/yiiframe.widgets.css',
    ];

    public $js = [
        'plugins/layer/layer.js',
        'plugins/sweetalert/sweetalert.min.js',
        'plugins/fancybox/jquery.fancybox.min.js',
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
