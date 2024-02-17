<?php

namespace common\queues;

use yiiframe\plugs\common\AddonHelper;
use Yii;
use yii\base\BaseObject;
use addons\Monitoring\common\models\ActionLog;

/**
 * Class ActionLogJob
 * @package common\queues
 * @author YiiFrame <21931118@qq.com>
 */
class ActionLogJob extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * 行为日志级别
     *
     * @var
     */
    public $level;

    /**
     * 行为日志
     *
     * @var ActionLog
     */
    public $actionLog;

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws \yii\base\InvalidConfigException
     */
    public function execute($queue)
    {
        if(AddonHelper::isInstall('Monitoring'))
            Yii::$app->monitoringService->log->realCreate($this->actionLog, $this->level);
    }
}