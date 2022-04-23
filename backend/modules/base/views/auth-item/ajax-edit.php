<?php

use yii\widgets\ActiveForm;
use common\helpers\Url;

/** @var ActiveForm $form */
/** @var \yii\db\ActiveRecord $model */

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
        <?= $form->field($model, 'pid')->dropDownList($dropDownList) ?>
        <?= $form->field($model, 'name')->textInput()->hint(Yii::t('app', '例如：/index/index，绝对路由')); ?>
        <?= $form->field($model, 'title')->textInput(); ?>
        <?= $form->field($model, 'sort')->textInput(); ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal"><?=Yii::t('app', '关闭');?></button>
        <button class="btn btn-primary" type="submit"><?=Yii::t('app', '保存');?></button>
    </div>
<?php ActiveForm::end(); ?>