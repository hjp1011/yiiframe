<?php

use yii\helpers\Json;
use common\helpers\Html;
use common\enums\StatusEnum;
use yiiframe\plugs\common\AddonHelper;
?>

<div class="form-group" style="padding-left: -15px">
    <?= Html::label(\Yii::t('app',$row['title']), $row['name'], ['class' => 'control-label demo']); ?>
    <?php if ($row['is_hide_remark'] != StatusEnum::ENABLED) { ?>
        <small><?= \yii\helpers\HtmlPurifier::process($row['remark']) ?></small>
    <?php } ?>
    <div class="col-sm-push-10">
        <?php
        if (AddonHelper::isInstall('Webuploader'))
        echo \addons\Webuploader\common\widgets\webuploader\Files::widget([
            'name' => "config[" . $row['name'] . "]",
            'value' => isset($row['value']['data']) ? Json::decode($row['value']['data']) : $row['default_value'],
            'type' => 'images',
            'theme' => 'default',
            'config' => [
                'pick' => [
                    'multiple' => true,
                ],
            ]
        ]) ?>
    </div>
</div>