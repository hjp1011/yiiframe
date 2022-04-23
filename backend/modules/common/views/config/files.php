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
    <div class="col-sm-push-10" style="padding-left: 15px">
        <?= \addons\Webuploader\common\widgets\webuploader\Files::widget([
            'name' => "config[" . $row['name'] . "]",
            'value' => isset($row['value']['data']) ? Json::decode($row['value']['data']) : $row['default_value'],
            'type' => 'files',
            'theme' => 'default',
            'config' => [
                'pick' => [
                    'multiple' => true,
                ],
            ]
        ]) ?>
    </div>
</div>