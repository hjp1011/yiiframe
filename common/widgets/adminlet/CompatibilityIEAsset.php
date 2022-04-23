<?php

namespace common\widgets\adminlet;

use yii\web\AssetBundle;

/**
 * Class CompatibilityIEAsset
 * @package backend\assets
 * @author YiiFrame <21931118@qq.com>
 */
class CompatibilityIEAsset extends AssetBundle
{
    public $js = [
        'dist/js/html5shiv.min.js',
        'dist/js/respond.min.js',
    ];

    public $jsOptions = [
        'condition' => 'lt IE 9',
        'position' => \yii\web\View::POS_HEAD
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/resources';
        parent::init();
    }
}