<?php

namespace backend\controllers;

use yiiframe\addonhelper\AddonHelper;
use Yii;
use backend\forms\ClearCache;
use common\helpers\ResultHelper;
use common\helpers\FileHelper;

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

        return $this->render($this->action->id, [
//            'member' => Yii::$app->services->backendReport->getMember(Yii::$app->services->merchant->getId())?:0,
//            'attachment' => Yii::$app->services->backendReport->getAttachment(Yii::$app->services->merchant->getId())?:0,
//            'behavior' => Yii::$app->services->backendReport->getActionBehavior(Yii::$app->services->merchant->getId())?:0,
//            'attachmentSize' => round(FileHelper::getDirSize(Yii::getAlias('@attachment'))/1024/1024),
//            'mysql_size' => Yii::$app->formatter->asShortSize(Yii::$app->services->backend->getDefaultDbSize(), 2),
//            'logCount' => Yii::$app->services->backendReport->getLog()?:0,
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
     * 用户指定时间内数量
     *
     * @param $type
     * @return array
     */
    public function actionMemberBetweenCount($type)
    {
        $data = Yii::$app->memberService->member->getBetweenCountStat($type);

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