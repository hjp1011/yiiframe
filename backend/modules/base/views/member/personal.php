<?php

$this->title = Yii::t('app', '编辑');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $this->render('_form', [
        'model' => $model,
        'backBtn' => '',
]) ?>
