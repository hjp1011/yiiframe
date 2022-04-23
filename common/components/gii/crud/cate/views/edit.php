<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\widgets\ActiveForm;
use common\helpers\Url;
use common\enums\StatusEnum;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['edit','id' => $model['id']]),
    'fieldConfig' => [
    'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
    ]
]);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h4 class="modal-title"><?= "<?=" ?> Yii::t('app','Edit'); ?></h4>
</div>
<div class="modal-body">
    <?= "<?= " ?> $form->field($model, 'pid')->dropDownList($cateDropDownList) ?>
    <?= "<?= " ?> $form->field($model, 'title')->textInput(); ?>
    <?= "<?= " ?> $form->field($model, 'sort')->textInput(); ?>
    <?= "<?= " ?> $form->field($model, 'status')->radioList(StatusEnum::getMap()); ?>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" type="submit"><?= "<?=" ?>Yii::t('app','Save');?></button>
    <span class="btn btn-white" onclick="history.go(-1)"><?= "<?=" ?>Yii::t('app', '返回');?></span>
</div>

<?= "<?php " ?> ActiveForm::end(); ?>

