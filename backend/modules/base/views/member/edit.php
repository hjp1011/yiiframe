<?php
$this->title = Yii::t('app', '编辑');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '用户管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $this->render('_form', [
    'model' => $model,
    'backBtn' => '<span class="btn btn-white" onclick="history.go(-1)">'.Yii::t('app', '返回').'</span>',
]) ?>
