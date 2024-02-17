<?php

namespace backend\modules\common\controllers;

use Yii;
use common\helpers\FileHelper;
use yiiframe\plugs\services\UpdateService;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;


/**
 * Class SystemController
 * @package backend\modules\base\controllers
 * @author YiiFrame <21931118@qq.com>
 */
class SystemController extends BaseController
{
    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionInfo()
    {
        // 禁用函数
        $disableFunctions = ini_get('disable_functions');
        $disableFunctions = !empty($disableFunctions) ? explode(',', $disableFunctions) : '未禁用';
        // 附件大小
        $attachmentSize = FileHelper::getDirSize(Yii::getAlias('@attachment'));
        if (!Yii::$app->debris->backendConfig('sys_dev')){
            $updateinfo['info'] = '已经是最新版本';
            $updateinfo['time'] = '';
        }
        else 
        $updateinfo = UpdateService::Version();
        return $this->render('info', [
            'mysql_size' => Yii::$app->services->backendReport->getDefaultDbSize(),
            'attachment_size' => $attachmentSize ?? 0,
            'disable_functions' => $disableFunctions,
            'updateinfo' => $updateinfo['info'],
            'domain_time' => $updateinfo['time'],
        ]);
    }
    public function actionUpdate()
    {
        if(!Yii::$app->session->get("token"))
            return    $this->message('请先绑定会员账号！', $this->redirect(Yii::$app->request->referrer), 'warning');
            try{
                $version =  UpdateService::download();
            }catch(\Exception $e){
                return $this->message($e->getMessage(), $this->redirect(['info']), 'error');
            }
            try{
                UpdateService::unzip();
                return $this->message('升级文件解压完成，请手动将/backend/runtime/update/下对应版本的文件覆盖到站点相应目录，注意：升级前请先对站点做好备份！', $this->redirect(['info']));
            }catch(\Exception $e){
                return $this->message($e->getMessage(), $this->redirect(['info']), 'error');
            }

    }


}