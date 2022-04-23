<?php

namespace services\merchant;

use common\components\Service;
use common\enums\MerchantStateEnum;
use common\enums\StatusEnum;
use yii\web\UnprocessableEntityHttpException;
use addons\Merchants\common\models\Merchant;

/**
 * 业企
 *
 * Class MerchantService
 * @package services\merchant
 * @author YiiFrame <21931118@qq.com>
 */
class MerchantService extends Service
{
    /**
     * @var int
     */
    protected $merchant_id = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->merchant_id;
    }

    /**
     * @param $merchant_id
     */
    public function setId($merchant_id)
    {
        $this->merchant_id = $merchant_id;
    }

    /**
     * @return int
     */
    public function getNotNullId(): int
    {
        return !empty($this->merchant_id) ? (int)$this->merchant_id : 0;
    }

    /**
     * @param $merchant_id
     */
    public function addId($merchant_id)
    {
        !$this->merchant_id && $this->merchant_id = $merchant_id;
    }

    /**
     * 查询并验证
     *
     * @param $merchant_id
     * @throws UnprocessableEntityHttpException
     */
    public function findVerifyPerfect($merchant_id)
    {
        $merchant = $this->findById($merchant_id);
        $this->verifyPerfect($merchant);
    }

    /**
     * 验证企业信息
     *
     * @param $merchant
     * @throws UnprocessableEntityHttpException
     */
    public function verifyPerfect($merchant)
    {
        if (empty($merchant)) {
            throw new UnprocessableEntityHttpException('找不到企业');
        }

        if ($merchant['state'] == StatusEnum::DELETE) {
            throw new UnprocessableEntityHttpException('企业已被关闭');
        }

        if ($merchant['state'] == StatusEnum::DELETE) {
            throw new UnprocessableEntityHttpException('企业正在审核中');
        }

        if ($merchant['status'] == StatusEnum::DISABLED) {
            throw new UnprocessableEntityHttpException('请先完善企业信息');
        }
    }

    /**
     * @return int|string
     */
    public function getCount($merchant_id = '')
    {
        return Merchant::find()
            ->select('id')
            ->where(['>=', 'status', StatusEnum::DISABLED])
            ->andWhere(['state' => StatusEnum::ENABLED])
            ->andFilterWhere(['id' => $merchant_id])
            ->count();
    }

    /**
     * @return int|string
     */
    public function getApplyCount($merchant_id = '')
    {
        return Merchant::find()
            ->select('id')
            ->where(['>=', 'status', StatusEnum::DISABLED])
            ->andWhere(['in', 'state', [MerchantStateEnum::AUDIT]])
            ->andFilterWhere(['id' => $merchant_id])
            ->count();
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findByLogin()
    {
        return $this->findById($this->getId());
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findById($id)
    {
        return Merchant::find()
            ->where(['>=', 'status', StatusEnum::DISABLED])
            ->andWhere(['id' => $id])
            ->one();
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findBaseById($id)
    {
        return Merchant::find()
            ->select([
                'id',
                'title',
                'cover',
                'address_name',
                'address_details',
                'longitude',
                'latitude',
                'collect_num',
            ])
            ->where(['id' => $id])
            ->andWhere(['status' => StatusEnum::ENABLED])
            ->asArray()
            ->one();
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findBaseByIds($ids)
    {
        return Merchant::find()
            ->select([
                'id',
                'title',
                'cover',
                'address_name',
                'address_details',
                'longitude',
                'latitude',
            ])
            ->where(['>=', 'status', StatusEnum::DISABLED])
            ->andWhere(['in', 'id', $ids])
            ->asArray()
            ->all();
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findBaseAll()
    {
        return Merchant::find()
            ->select([
                'id',
                'title',
                'cover',
                'address_name',
                'address_details',
                'longitude',
                'latitude',
            ])
            ->where(['>=', 'status', StatusEnum::DISABLED])
            ->asArray()
            ->all();
    }
}