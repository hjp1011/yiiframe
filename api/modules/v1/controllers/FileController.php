<?php

namespace api\modules\v1\controllers;

use addons\Webuploader\common\traits\FileActions;
use api\controllers\OnAuthController;

/**
 * 资源上传控制器
 */
class FileController extends OnAuthController
{
    use FileActions;
    protected $authOptional = ['images'];

    /**
     * @var string
     */
    public $modelClass = '';
}