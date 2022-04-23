<?php

namespace common\traits;

use addons\Merchants\common\models\Merchant;

/**
 * Trait HasOneMerchant
 * @package common\traits
 * @author YiiFrame <21931118@qq.com>
 */
trait HasOneMerchant
{
    /**
     * 关联企业
     *
     * @return mixed
     */
    public function getMerchant()
    {
        return $this->hasOne(Merchant::class, ['id' => 'merchant_id'])->select([
            'id',
            'title',
            'cover',
            'address_name',
            'address_details',
            'longitude',
            'latitude',
            'collect_num',
        ])->cache(60);
    }
}