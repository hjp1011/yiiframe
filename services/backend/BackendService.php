<?php

namespace services\backend;

use Yii;
use common\enums\AppEnum;
use common\components\Service;

/**
 * Class BackendService
 * @package services\backend
 * @author YiiFrame <21931118@qq.com>
 */
class BackendService extends Service
{
    /**
     * @return int
     * @throws \yii\db\Exception
     */
    public function getDefaultDbSize()
    {
        $db = Yii::$app->db;
        $models = $db->createCommand('SHOW TABLE STATUS')->queryAll();
        $models = array_map('array_change_key_case', $models);
        // 数据库大小
        $mysqlSize = 0;
        foreach ($models as $model) {
            $mysqlSize += $model['data_length'];
        }

        return $mysqlSize;
    }

    /**
     * @param $model
     * @return string
     */
    public function getUserName($model)
    {
        switch ($model->app_id) {
            case AppEnum::BACKEND :
                if (!empty($model->member)) {
                    $str = [];
                    $str[] = "ID：" . $model->member->id;
                    $str[] = Yii::t('app','账号').":" . $model->member->username;
                    $str[] = Yii::t('app','姓名').":" . $model->member->realname;

                    return implode("<br>", $str);
                }

                return '游客';
                break;
            case AppEnum::MERCHANT :
                if (!empty($model->member)) {
                    $str = [];
                    $str[] = 'ID：' . $model->member->id;
                    $str[] = '账号：' . $model->member->username;
                    $str[] = '姓名：' . $model->member->realname;

                    return implode("<br>", $str);
                }

                return '游客';

                break;
            case AppEnum::OAUTH2 :
                if (!empty($model->member)) {
                    $str = [];
                    $str[] = 'ID：' . $model->member->id;
                    $str[] = '账号：' . $model->member->username;
                    $str[] = '昵称：' . $model->member->nickname;
                    $str[] = '姓名：' . $model->member->realname;

                    return implode("<br>", $str);
                }

                return '游客';

                break;
            default :
                if (!empty($model->member)) {
                    $str = [];
                    $str[] = 'ID：' . $model->member->id;
                    $str[] = '账号：' . $model->member->username;
//                    $str[] = '昵称：' . $model->member->nickname;
                    $str[] = '姓名：' . $model->member->realname;

                    return implode("<br>", $str);
                }

                return '游客';

                break;
        }
    }
}