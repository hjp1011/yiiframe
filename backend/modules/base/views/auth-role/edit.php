<?php

use yii\widgets\ActiveForm;
use common\helpers\Url;
use common\enums\StatusEnum;

$this->title = $model->isNewRecord ? Yii::t('app', '创建') : Yii::t('app', '编辑');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '角色管理'), 'url' => ['index', 'merchant_id' => $merchant_id]];
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
                'fieldConfig' => [
                    //'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}{hint}{error}</div>",
                ],
            ]); ?>
            <div class="box-body">
                <?= $form->field($model, 'pid')->dropDownList($dropDownList) ?>
                <?= $form->field($model, 'title')->textInput(); ?>
                <?= $form->field($model, 'status')->radioList(StatusEnum::getMap()); ?>
                <?= $form->field($model, 'sort')->textInput(); ?>
                <div class="col-sm-2"></div>
                <div class="col-sm-5">
                    <?= \common\widgets\jstree\JsTree::widget([
                        'name' => "userTree",
                        'defaultData' => $defaultFormAuth,
                        'selectIds' => $defaultCheckIds,
                    ]) ?>
                </div>
                <div class="col-sm-5">
                    <?= \common\widgets\jstree\JsTree::widget([
                        'name' => "plugTree",
                        'defaultData' => $addonsFormAuth,
                        'selectIds' => $addonsCheckIds,
                    ]) ?>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-sm-12 text-center">
                    <button class="btn btn-primary" type="button" onclick="submitForm()"><?=Yii::t('app', '保存');?></button>
                    <span class="btn btn-white" onclick="history.go(-1)"><?=Yii::t('app', '返回');?></span>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    // 提交表单
    function submitForm() {

        var userTreeIds = getCheckTreeIds("userTree");
        var plugTreeIds = getCheckTreeIds("plugTree");

        rfAffirm("<?=Yii::t('app','保存中')?>"+'...',"<?=Yii::t('app','一个基于Yii2的安全、高效的开发框架')?>","<?=Yii::t('app','确认')?>");

        $.ajax({
            type: "post",
            url: "<?= Url::to(['edit', 'id' => $model->id, 'merchant_id' => $merchant_id])?>",
            dataType: "json",
            data: {
                id: '<?= $model['id']?>',
                pid: $("#authrole-pid").val(),
                sort: $("#authrole-sort").val(),
                status: $("input[name='AuthRole[status]']:checked").val(),
                title: $("#authrole-title").val(),
                userTreeIds: userTreeIds,
                plugTreeIds: plugTreeIds
            },
            success: function (data) {
                if (parseInt(data.code) === 200) {
                    window.location = "<?= Url::to(['index', 'merchant_id' => $merchant_id])?>";
                } else {
                    rfError(data.message,"<?=Yii::t('app','一个基于Yii2的安全、高效的开发框架')?>","<?=Yii::t('app','确认')?>");
                }
            }
        });
    }
</script>