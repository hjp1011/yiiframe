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
use common\helpers\Html;
/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */

$this->title = <?= $generator->generateString(Inflector::camel2words('Progress')) ?>;$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = true;
foreach ($model->getNextStatuses() as $key => $nextStatus) {
    $status = false;
}
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
                <?= "<?php " ?>$form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="timeline">
                            <li class="time-label">
                          <span class="bg-blue">
                            <?= "<?=" ?> Yii::t('app','Begin'); ?>
                          </span>
                            </li>
                            <?= "<?php " ?>foreach ($model->log ?? [] as $log) {
                                ?>
                                <li>
                                    <i class="fa fa-user bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i
                                                    class="fa fa-clock-o"></i> <?= "<?= " ?> date("Y-m-d H:i:s", $log->time) ?></span>
                                        <h3 class="timeline-header"><?= "<?= " ?>Yii::$app->services->devPattern->getName($log->id);?><?= "<?= " ?> \addons\Flow\common\enums\WorkflowEnum::getValue(explode('/', $log->action)[1]) ?></h3>
                                        <div class="timeline-body">
                                            <?= "<?= " ?> $log->suggest??$model->content; ?>
                                        </div>
                                    </div>
                                </li>
                            <?= "<?php " ?>}?>

                            <?= "<?php " ?> if ($status) { ?>
                                <li class="time-label">
                              <span class="bg-yellow">
                                <?= "<?=" ?> Yii::t('app','End'); ?>
                              </span>
                                </li>
                            <?= "<?php " ?> } else { ?>
                                <li>
                                    <i class="fa fa-clock-o bg-gray"></i>
                                </li>
                            <?= "<?php " ?> } ?>
                        </ul>

                    </div>
                </div>
                <?= "<?php " ?>ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
