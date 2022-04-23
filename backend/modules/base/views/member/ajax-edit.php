<?php

use yii\widgets\ActiveForm;
use common\helpers\Url;

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['ajax-edit', 'id' => $model['id']]),
    'fieldConfig' => [
        'template' => "<div class='col-sm-1'>{label}</div><div class='col-sm-11'>{input}\n{hint}\n{error}</div>",
    ]
]);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><?=Yii::t('app', '编辑');?></h4>
</div>
<div class="modal-body">
    <?= $form->field($model, 'realname')->textInput()?>
    <?= $form->field($model, 'mobile')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?php if ($model->id != Yii::$app->params['adminAccount']) { ?>
        <?= $form->field($model, 'role_id')->dropDownList($roles) ?>
    <?php } ?>
    <?= $form->field($model, 'department_id')->dropDownList($departments, [
        'prompt' => Yii::t('app', '请选择'),
    ]) ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal"><?=Yii::t('app', '关闭');?></button>
    <button class="btn btn-primary" type="submit"><?=Yii::t('app', '保存');?></button>
</div>
<?php ActiveForm::end(); ?>
