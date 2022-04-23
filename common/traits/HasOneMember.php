<?php

namespace common\traits;

use Yii;
/**
 * Trait HasOneMember
 * @package addons\TinyShop\common\traits
 */
trait HasOneMember
{
    /**
     * 用户信息
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBaseMember()
    {
        if (Yii::$app->services->devPattern->isGroup())
            return $this->hasOne(\addons\Merchants\common\models\Member::class, ['id' => 'member_id'])->select(['id', 'realname', 'mobile', 'head_portrait']);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return $this->hasOne(\common\models\backend\Member::class, ['id' => 'member_id'])->select(['id', 'realname', 'mobile', 'head_portrait']);
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return $this->hasOne(\addons\Member\common\models\Member::class, ['id' => 'member_id'])->select(['id', 'realname', 'mobile', 'head_portrait']);
    }
}