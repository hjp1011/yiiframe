<?php
namespace services\backend;


use Yii;
use common\enums\StatusEnum;
use common\components\Service;
use common\models\backend\Member;
use addons\Attachment\common\models\Attachment;
use common\helpers\EchantsHelper;
use addons\Log\common\models\Log;
use addons\Monitoring\common\models\ActionLog;

/**
 * Class MemberService
 * @package addons\TinyShop\services\member
 * @author YiiFrame <21931118@qq.com>
 */
class ReportService extends Service
{
    //统计日志
    public function getLog()
    {
        return Log::find()
            ->select('id')
            ->andWhere(['>', 'status', StatusEnum::DISABLED])
            ->count();
    }
    //行为监控
    public function getActionBehavior()
    {
        return ActionLog::find()
            ->select('id')
            ->andWhere(['>', 'status', StatusEnum::DISABLED])
            ->count();
    }
    //统计资源
    public function getAttachment()
    {
        return Attachment::find()
            ->select('id')
            ->andWhere(['>', 'status', StatusEnum::DISABLED])
            ->count();
    }
    //统计会员
    public function getMember($merchant_id = '')
    {
        return Member::find()
            ->select('id')
            ->andWhere(['>', 'status', StatusEnum::DISABLED])
            ->count();
    }

    public function getLogin($type)
    {
        $fields = [
            'success' => Yii::t('app','成功'),
            'false' => Yii::t('app','失败'),
        ];
        // 获取时间和格式化
        list($time, $format) = EchantsHelper::getFormatTime($type);
        // 获取数据
        return EchantsHelper::lineOrBarInTime(function ($start_time, $end_time, $formatting) {
//            $where = [];
            return ActionLog::find()
                ->select([
                    'count(user_id!=0 or null) as success',
                    'count(user_id=0 or null) as false',
                    "from_unixtime(created_at, '$formatting') as time"])
                ->where(['>', 'status', StatusEnum::DISABLED])
//                ->andWhere(['remark'=>'账号登录'])
                ->andWhere(['between', 'created_at', $start_time, $end_time])
                ->andWhere(['behavior'=> 'login'])
//                ->andFilterWhere($where)
                ->groupBy(['time'])
                ->asArray()
                ->all();
        }, $fields, $time, $format);
    }

}