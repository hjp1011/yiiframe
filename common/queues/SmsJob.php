<?php

namespace common\queues;

use Yii;
use yii\base\BaseObject;
use yiiframe\addonhelper\AddonHelper;

/**
 * Class SmsJob
 * @package common\queues
 * @author YiiFrame <21931118@qq.com>
 */
class SmsJob extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * @var
     */
    public $mobile;

    /**
     * @var
     */
    public $code;

    /**
     * @var
     */
    public $usage;

    /**
     * @var
     */
    public $member_id;

    /**
     * @var
     */
    public $ip;

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function execute($queue)
    {
        if(AddonHelper::isInstall('AliyunSms'))
        Yii::$app->aliyunSmsService->sms->realSend($this->mobile, $this->code, $this->usage, $this->member_id, $this->ip);
    }
}