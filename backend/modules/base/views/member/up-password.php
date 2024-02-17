<?php

use yii\widgets\ActiveForm;
use common\helpers\Url;

$this->title = Yii::t('app', 'Password');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 style="font-size: 18px;padding-top: 0;margin-top: 0">
                    <i class="icon ion-android-apps"></i>
                    <?=Yii::t('app', '编辑');?>
                </h2>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'pwd',
                'fieldConfig' => [
                    //'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}{hint}{error}</div>",
                ]
            ]); ?>
            <div class="box-body">
                <?= $form->field($model, 'passwd')->passwordInput() ?>
                <?= $form->field($model, 'passwd_new')->passwordInput() ?>
                <?= $form->field($model, 'passwd_repetition')->passwordInput() ?>
            </div>
            <div class="box-footer text-center">
                <button class="btn btn-primary" type="submit"><?=Yii::t('app', '保存')?></button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    var $form = $('#pwd');
    $form.on('beforeSubmit', function () {
        var data = $form.serialize();

        $.ajax({
            type: "post",
            url: "<?= Url::to(['up-password']); ?>",
            dataType: "json",
            data: data,
            success: function (data) {
                if (parseInt(data.code) === 200) {
                    parent.location.reload();
                    window.location.reload();
                } else {
                    rfWarning(data.message,"<?=Yii::t('app','一个基于Yii2的安全、高效的开发框架')?>","<?=Yii::t('app','确认')?>");
                }
            }
        });

        return false; // 防止默认提交
    });
</script>