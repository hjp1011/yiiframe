<?php

namespace common\queues;

use yiiframe\plugs\common\AddonHelper;
use Yii;
use yii\base\BaseObject;
use addons\ReceiptPrinter\common\models\HardwareConfig;

/**
 * 小票打印
 *
 * Class ReceiptPrinterJob
 * @package common\queues
 * @author YiiFrame <21931118@qq.com>
 */
class ReceiptPrinterJob extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * @var HardwareConfig
     */
    public $config;

    /**
     * @var array
     */
    public $data = [];

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws \yii\base\InvalidConfigException
     */
    public function execute($queue)
    {
        if(AddonHelper::isInstall('ReceiptPrinter'))
        Yii::$app->receiptPrinterService->hardware->receiptPrinter($this->config, $this->data);
    }
}