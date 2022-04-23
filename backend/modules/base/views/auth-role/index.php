<?php

use common\helpers\Url;
use common\helpers\Html;
use yiiframe\treegrid\TreeGrid;

$this->title = Yii::t('app', '角色管理');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h2 style="font-size: 18px;padding-top: 0;margin-top: 0">
                    <i class="icon ion-android-apps"></i>
                    <?= $this->title; ?>
                </h2>
                <div class="box-tools">
                    <?= Html::create(['edit','merchant_id' => $merchant_id],Yii::t('app', '创建') ); ?>
                </div>
            </div>
            <div class="box-body table-responsive">
                <?= Treegrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'id',
                    'parentColumnName' => 'pid',
                    'parentRootValue' => $role['id'] ?? 0, // first parentId value
                    'pluginOptions' => [
                        // 'initialState' => 'collapsed',
                    ],
                    'options' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) use ($merchant_id) {
                                $str = Html::tag('span', $model['title'], [
                                    'class' => 'm-l-sm',
                                ]);
                                $str .= Html::a(' <i class="icon ion-android-add-circle"></i>',
                                    ['edit', 'pid' => $model['id'], 'merchant_id' => $merchant_id]);

                                return $str;
                            },
                        ],
                        [
                            'attribute' => 'sort',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'col-md-1'],
                            'value' => function ($model, $key, $index, $column) {
                                return Html::sort($model['sort']);
                            },
                        ],
                        [
                            'header' =>Yii::t('app', '操作'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{status} {edit} {delete}',
                            'buttons' => [

                                'status' => function ($url, $model, $key) {
                                    return Html::status($model['status']);
                                },
                                'edit' => function ($url, $model, $key) use ($merchant_id) {
                                    return Html::edit(['edit', 'id' => $model['id'], 'merchant_id' => $merchant_id],Yii::t('app', '编辑'));
                                },
                                'delete' => function ($url, $model, $key) use ($merchant_id) {
                                    return Html::delete(['delete', 'id' => $model['id'], 'merchant_id' => $merchant_id,
                                    ],Yii::t('app', '删除'));
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>