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

use common\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

$this->title = <?= $generator->generateString(Inflector::camel2words('编辑')) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 style="font-size: 18px;padding-top: 0;margin-top: 0">
                    <i class="icon ion-android-apps"></i>
                    <?= "<?=" ?> Html::encode($this->title) ?>
                </h2>
            </div>
            <div class="box-body">
                <?= "<?php " ?>$form = ActiveForm::begin([
                    'fieldConfig' => [
                        //'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
                    ],
                ]); ?>
                <div class="col-sm-12">
<?php
if (!empty($generator->formFields)) {
    foreach ($generator->formFields as $attribute) {
        if($attribute=='status')
            echo "                    <?= \$form->field(\$model, 'status')->radioList(\common\\enums\StatusEnum::getMap()) ?>\n";
        else
            echo "                    <?= " . $generator->generateActiveField($attribute) . " ?>\n";
    }
} else {
    foreach ($generator->getColumnNames() as $attribute) {
        if (in_array($attribute, $safeAttributes)) {
            echo "                    <?= " . $generator->generateActiveField($attribute) . " ?>\n";
        }
    }
}?>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <button class="btn btn-primary" type="submit"><?= "<?=" ?>Yii::t('app','保存');?></button>
                        <span class="btn btn-white" onclick="history.go(-1)"><?= "<?=" ?>Yii::t('app', '返回');?></span>
                    </div>
                </div>
                <?= "<?php " ?>ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
