<?php

namespace common\queues;

use yiiframe\plugs\common\AddonHelper;
use Yii;
use yii\base\BaseObject;

/**
 * Class LogJob
 * @package common\queues
 * @author YiiFrame <21931118@qq.com>
 */
class LogJob extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * 日志记录数据
     *
     * @var
     */
    public $data;

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws \yii\base\InvalidConfigException
     */
    public function execute($queue)
    {
        if(AddonHelper::isInstall('Log'))
            Yii::$app->logService->log->realCreate($this->data);
    }
}