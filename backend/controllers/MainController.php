<?php

namespace backend\controllers;

use Yii;
use common\helpers\ResultHelper;
use yiiframe\plugs\common\AddonHelper;
use common\helpers\FileHelper;
use backend\forms\ClearCache;
use yiiframe\plugs\services\UpdateService;

/**
 * 主控制器
 *
 * Class MainController
 * @package backend\controllers
 * @author YiiFrame <21931118@qq.com>
 */
class MainController extends BaseController
{
    /**
     * 系统首页
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderPartial($this->action->id, [
        ]);
    }

    /**
     * 子框架默认主页
     *
     * @return string
     */
    public function actionSystem()
    {

        $attachment = AddonHelper::isInstall('Webuploader')?Yii::$app->services->backendReport->getAttachment(Yii::$app->services->merchant->getId()):0;
        $behavior = AddonHelper::isInstall('Monitoring')?Yii::$app->services->backendReport->getActionBehavior(Yii::$app->services->merchant->getId()):0;
        $logCount = AddonHelper::isInstall('Log')?Yii::$app->services->backendReport->getLog():0;
        return $this->render($this->action->id, [
           'member' => Yii::$app->services->backendReport->getMember(Yii::$app->services->merchant->getId())?:0,
           'attachmentSize' => round(FileHelper::getDirSize(Yii::getAlias('@attachment'))/1024/1024),
           'mysql_size' => Yii::$app->formatter->asShortSize(Yii::$app->services->backendReport->getDefaultDbSize()),
           'attachment' => $attachment,
           'behavior' => $behavior,
           'logCount' => $logCount,
        ]);
    }
    /**
     * 登陆统计
     *
     * @param $type
     * @return array
     */
    public function actionLoginCount($type)
    {
        if(AddonHelper::isInstall('Monitoring'))
        $data = Yii::$app->services->backendReport->getLogin($type);
        else $data=[];
        return ResultHelper::json(200, '获取成功', $data);
    }
    /**
     * 会员统计
     * @param $type
     * @return array
     */
    public function actionMemberCount($type)
    {
        $data = Yii::$app->services->backendReport->getMemberCountStat($type);

        return ResultHelper::json(200, '获取成功', $data);
    }
    /**
     * 日志统计
     * @param $type
     * @return array
     */
    public function actionLogCount($type)
    {
        if(AddonHelper::isInstall('Log'))
        $data = Yii::$app->services->backendReport->getLogCountStat($type);
        else $data=[];
        return ResultHelper::json(200, '获取成功', $data);
    }

    /**
     * 清理缓存
     *
     * @return string
     */
    public function actionClearCache()
    {
        return Yii::$app->cache->flush()
            ?$this->message(Yii::t('app','缓存清理成功'), $this->redirect(['/main/system']))
            :$this->message(Yii::t('app','缓存清理失败'), $this->redirect(['/main/system']));
    }
}