<?php

use common\helpers\Html;
use common\enums\StatusEnum;

?>

<div class="form-group">
    <?= Html::label(\Yii::t('app',$row['title']), $row['name'], ['class' => 'control-label demo']); ?>
    <?php if ($row['is_hide_remark'] != StatusEnum::ENABLED) { ?>
        <small><?= \yii\helpers\HtmlPurifier::process(\Yii::t('app',$row['remark'])) ?></small>
    <?php } ?>
    <div class="col-sm-push-10">
        <?= \kartik\datetime\DateTimePicker::widget([
            'name' => "config[" . $row['name'] . "]",
            'value' => $row['value']['data'] ?? $row['default_value'],
            'language' => 'zh-CN',
            'layout' => '{picker}{remove}{input}',
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd hh:ii',
                'todayHighlight' => true,//今日高亮
                'autoclose' => true,//选择后自动关闭
                'todayBtn' => true,//今日按钮显示
            ],
            'options' => [
                'class' => 'form-control no_bor',
            ]
        ]) ?>
    </div>
</div>