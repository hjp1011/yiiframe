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

$this->title = <?= $generator->generateString(Inflector::camel2words('Create')) ?>;
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
        if($attribute=='cate_id')
            echo "                    <?= \$form->field(\$model, 'cate_id')->widget(Select2::class, [
                        'data' => \$cates,
                        'options' => ['placeholder' => Yii::t('app','请选择')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>\n";
        elseif($attribute=='covers')
            echo "                    <?= \$form->field(\$model, 'covers')->widget(addons\Webuploader\common\widgets\webuploader\Files::class, [
                            'config' => [
                                'pick' => [
                                    'multiple' => true,
                                ],
                            ]
                        ]); 
                    ?>\n";
        elseif($attribute=='begin_date')
            echo "                    <?= \$form->field(\$model, 'begin_date')->widget('kartik\date\DatePicker', [
                        'language' => 'zh-CN',
                        'layout' => '{picker}{input}',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,// 今日高亮
                            'autoclose' => true,// 选择后自动关闭
                            'todayBtn' => true,// 今日按钮显示
                        ],
                        'options' => [
                            'class' => 'form-control no_bor',
                        ]
                    ]); ?>\n";
        elseif($attribute=='end_date')
            echo "                    <?= \$form->field(\$model, 'end_date')->widget('kartik\date\DatePicker', [
                        'language' => 'zh-CN',
                        'layout' => '{picker}{input}',
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,// 今日高亮
                            'autoclose' => true,// 选择后自动关闭
                            'todayBtn' => true,// 今日按钮显示
                        ],
                        'options' => [
                            'class' => 'form-control no_bor',
                        ]
                    ]); ?>\n";
        elseif($attribute=='status')
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
                        <button class="btn btn-primary" type="submit"><?= "<?=" ?>Yii::t('app','Save');?></button>
                        <span class="btn btn-white" onclick="history.go(-1)"><?= "<?=" ?>Yii::t('app', '返回');?></span>
                    </div>
                </div>
                <?= "<?php " ?>ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
