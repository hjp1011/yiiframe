<?php

use common\helpers\Html;
use yiiframe\treegrid\TreeGrid;

$this->title = Yii::t('app', '部门管理');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h2 style="font-size: 18px;padding-top: 0;margin-top: 0">
                    <i class="icon ion-android-apps"></i>
                    <?= Yii::t('app', '部门管理'); ?>
                </h2>
                <div class="box-tools">
                    <?= Html::create(['ajax-edit'], Yii::t('app', '创建'), [
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModalLg',
                    ]) ?>
                </div>
            </div>
            <div class="box-body table-responsive">
                <?= Treegrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'id',
                    'parentColumnName' => 'pid',
                    'parentRootValue' => '0', //first parentId value
                    'pluginOptions' => [
                        'initialState' => 'collapsed',
                    ],
                    'options' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                $str = Html::tag('span', $model->title, [
                                    'class' => 'm-l-sm',
                                ]);
                                $str .= Html::a(' <i class="icon ion-android-add-circle"></i>',
                                    ['ajax-edit', 'pid' => $model['id']], [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#ajaxModalLg',
                                    ]);

                                return $str;
                            },
                        ],
                        [
                            'attribute' => 'index_block_status',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'col-md-1'],
                            'value' => function ($model, $key, $index, $column) {
                                return Html::whether($model->index_block_status);
                            },
                        ],
                        [
                            'attribute' => 'sort',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'col-md-1'],
                            'value' => function ($model, $key, $index, $column) {
                                return Html::sort($model->sort);
                            },
                        ],
                        [
                            'header' => Yii::t('app', '操作'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => ' {status} {edit} {delete}',
                            'buttons' => [
                                'edit' => function ($url, $model, $key) {
                                    return Html::edit(['ajax-edit', 'id' => $model->id], Yii::t('app', '编辑'), [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#ajaxModalLg',
                                    ]);
                                },
                                'status' => function ($url, $model, $key) {
                                    return Html::status($model->status);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::delete(['delete', 'id' => $model->id]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>