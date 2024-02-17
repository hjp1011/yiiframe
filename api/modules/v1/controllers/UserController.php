<?php

namespace api\modules\v1\controllers;
use yii\rest\ActiveController;
class UserController extends ActiveController
{
    public $modelClass = 'common\models\backend\Member';
}
