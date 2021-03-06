<?php

namespace services\merapi;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UnprocessableEntityHttpException;
use common\enums\CacheEnum;
use common\helpers\ArrayHelper;
use common\models\merapi\AccessToken;
use common\components\Service;
use common\enums\StatusEnum;
use common\enums\MerchantStateEnum;
use addons\Merchants\common\models\Merchant;
use addons\Merchants\common\models\Member;

/**
 * Class AccessTokenService
 * @package services\merapi
 * @author YiiFrame <21931118@qq.com>
 */
class AccessTokenService extends Service
{
    /**
     * 是否加入缓存
     *
     * @var bool
     */
    public $cache = false;

    /**
     * 缓存过期时间
     *
     * @var int
     */
    public $timeout;

    /**
     * 获取token
     *
     * @param Member $member
     * @param $group
     * @param int $cycle_index 重新获取次数
     * @return array
     * @throws \yii\base\Exception
     */
    public function getAccessToken(Member $member, $group, $cycle_index = 1)
    {
        $model = $this->findModel($member->id, $group);
        $model->member_id = $member->id;
        $model->merchant_id = $member->merchant_id;
        $model->group = $group;
        // 删除缓存
        !empty($model->access_token) && Yii::$app->cache->delete($this->getCacheKey($model->access_token));
        $model->refresh_token = Yii::$app->security->generateRandomString() . '_' . time();
        $model->access_token = Yii::$app->security->generateRandomString() . '_' . time();
        $model->status = StatusEnum::ENABLED;

        if (!$model->save()) {
            if ($cycle_index <= 3) {
                $cycle_index++;
                return self::getAccessToken($member, $group, $cycle_index);
            }

            throw new UnprocessableEntityHttpException($this->getError($model));
        }

        $result = [];
        $result['refresh_token'] = $model->refresh_token;
        $result['access_token'] = $model->access_token;
        $result['expiration_time'] = Yii::$app->params['user.accessTokenExpire'];

        // 记录访问次数
        Yii::$app->merchantsService->member->lastLogin($member);

        // 关联账号信息
        /** @var Merchant $merchant */
        if ($merchant = $member->merchant) {
            if ($merchant->status == StatusEnum::DELETE) {
                throw new UnprocessableEntityHttpException('所属企业不存在');
            }
            if ($merchant->state == MerchantStateEnum::DISABLED) {
                throw new UnprocessableEntityHttpException('所属企业未通过审核');
            }
            if ($merchant->state == MerchantStateEnum::AUDIT) {
                throw new UnprocessableEntityHttpException('所属企业正在审核');
            }
        } else {
            throw new UnprocessableEntityHttpException('所属企业不存在');
        }

        $account = $member->account;
        $member = ArrayHelper::toArray($member);
        unset($member['password_hash'], $member['auth_key'], $member['password_reset_token'], $member['access_token'], $member['refresh_token']);
        $result['member'] = $member;
        $result['member']['merchant'] = ArrayHelper::toArray($merchant);
        $result['member']['account'] = ArrayHelper::toArray($account);

        // 写入缓存
        $this->cache === true && Yii::$app->cache->set($this->getCacheKey($model->access_token), $model, $this->timeout);

        return $result;
    }

    /**
     * @param $token
     * @param $type
     * @return array|mixed|null|ActiveRecord
     */
    public function getTokenToCache($token, $type)
    {
        if ($this->cache == false) {
            return $this->findByAccessToken($token);
        }

        $key = $this->getCacheKey($token);
        if (!($model = Yii::$app->cache->get($key))) {
            $model = $this->findByAccessToken($token);
            Yii::$app->cache->set($key, $model, $this->timeout);
        }

        return $model;
    }

    /**
     * 禁用token
     *
     * @param $access_token
     */
    public function disableByAccessToken($access_token)
    {
        $this->cache === true && Yii::$app->cache->delete($this->getCacheKey($access_token));

        if ($model = $this->findByAccessToken($access_token)) {
            $model->status = StatusEnum::DISABLED;
            return $model->save();
        }

        return false;
    }

    /**
     * 获取token
     *
     * @param $token
     * @return array|null|ActiveRecord|AccessToken
     */
    public function findByAccessToken($token)
    {
        return AccessToken::find()
            ->where(['access_token' => $token, 'status' => StatusEnum::ENABLED])
            ->andFilterWhere(['merchant_id' => \Yii::$app->user->identity->merchant_id])
            ->one();
    }

    /**
     * @param $access_token
     * @return string
     */
    protected function getCacheKey($access_token)
    {
        return CacheEnum::getPrefix('merapiAccessToken') . $access_token;
    }

    /**
     * 返回模型
     *
     * @param $member_id
     * @param $group
     * @return array|AccessToken|null|ActiveRecord
     */
    protected function findModel($member_id, $group)
    {
        if (empty(($model = AccessToken::find()->where([
            'member_id' => $member_id,
            'group' => $group
        ])->andFilterWhere(['merchant_id' => \Yii::$app->user->identity->merchant_id])->one()))) {
            $model = new AccessToken();
            return $model->loadDefaultValues();
        }

        return $model;
    }
}