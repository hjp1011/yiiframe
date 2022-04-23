<?php

use yii\helpers\Json;
use common\helpers\Html;
use common\enums\StatusEnum;

?>

<div class="form-group">
    <?= Html::label(\Yii::t('app',$row['title']), $row['name'], ['class' => 'control-label demo']); ?>
    <?php if ($row['is_hide_remark'] != StatusEnum::ENABLED) { ?>
        <small><?= \yii\helpers\HtmlPurifier::process(\Yii::t('app',$row['remark'])) ?></small>
    <?php } ?>
    <div class="col-sm-push-10">
        <?= \addons\Map\common\widgets\selectmap\Map::widget([
            'name' => "config[" . $row['name'] . "]",
            'value' => isset($row['value']['data']) ? Json::decode($row['value']['data']) : [],
            'type' => !empty($option[0]) ? $option[0] : 'amap', // amap高德;tencent:腾讯;baidu:百度
        ]) ?>
    </div>
</div>