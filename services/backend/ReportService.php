<?php
namespace services\backend;

use Yii;
use common\enums\StatusEnum;
use common\components\Service;
use common\models\backend\Member;
use common\helpers\EchantsHelper;
use addons\Log\common\models\Log;
use addons\Monitoring\common\models\ActionLog;
use addons\Webuploader\common\models\Attachment;

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
    /**统计数据库大小
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
     * 用户登陆统计
     *
     * @return array|\yii\db\ActiveRecord|null
     */
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
            return ActionLog::find()
                ->select([
                    'count(user_id!=0 or null) as success',
                    'count(user_id=0 or null) as false',
                    "from_unixtime(created_at, '$formatting') as time"])
                ->where(['>', 'status', StatusEnum::DISABLED])
                ->andWhere(['between', 'created_at', $start_time, $end_time])
                ->andWhere(['behavior'=> 'login'])
                ->groupBy(['time'])
                ->asArray()
                ->all();
        }, $fields, $time, $format);
    }
    /**
     * 用户访问统计
     *
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getMemberCountStat($type)
    {
        $fields = [
            
        ];
        list($time, $format) = EchantsHelper::getFormatTime('all');
        // 获取数据
        return EchantsHelper::pie(function ($start_time, $end_time) use ($fields) {
            $result = Member::find()
                ->select(['realname as name','SUM(visit_count) as value'])
                ->where(['>', 'status', StatusEnum::DISABLED])
                ->groupBy(['realname'])
                ->andFilterWhere(['merchant_id' => $this->getMerchantId()])
                ->asArray()
                ->all();
            return [$result, $fields];
        },$time,['name' => '登录次数']);
    }
    /**
     * 日志分布统计
     * @param $type
     * @return array
     */
    public function getLogCountStat($type)
    {
        // 获取时间和格式化
        list($time, $format) = EchantsHelper::getFormatTime($type);

        // 获取数据
        return EchantsHelper::wordCloud(function ($start_time, $end_time) {
            return Log::find()
                ->select([
                    'error_code as name','count(error_code) as value'
                ])
                // ->andWhere(['between', 'created_at', $start_time, $end_time])
                ->groupBy(['error_code'])
                ->andFilterWhere(['merchant_id' => $this->getMerchantId()])
                ->asArray()
                ->all();
        }, $time);
    }

}