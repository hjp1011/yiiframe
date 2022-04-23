<?php

use common\enums\ConfigTypeEnum;
use common\helpers\Url;
use common\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', '配置列表');
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="<?= Url::to(['config/index']) ?>"> <?=Yii::t('app', '配置列表')?></a></li>
                <li><a href="<?= Url::to(['config-cate/index']) ?>"> <?=Yii::t('app', '配置分类')?></a></li>
                <li class="pull-right">
                    <?= Html::create(['ajax-edit'], [
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModalLg',
                    ]) ?>
                </li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        //重新定义分页样式
                        'tableOptions' => [
                            'class' => 'table table-hover rf-table',
                            'fixedNumber' => 1,
                            //'fixedRightNumber' => 1,
                        ],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                            ],
                            [
                                'attribute'=>'title',
                                'value' => function ($model) {
                                    return Yii::t('app', $model->title);
                                },
                            ],
                            [
                                'attribute'=>'name',
                                'value' => function ($model) {
                                    return Yii::t('app', $model->name);
                                },
                            ],
                            [
                                'attribute' => 'sort',
                                'value' => function ($model) {
                                    return Html::sort($model->sort);
                                },
                                'filter' => false,
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'col-md-1'],
                            ],
                            [
                                'label' => Yii::t('app', '分类'),
                                'attribute' => 'cate.title',
                                'value' => function ($model) {
                                    return Yii::t('app', $model->cate->title);
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'cate_id', $cateDropDownList, [
                                        'prompt' => Yii::t('app', 'All'),
                                        'class' => 'form-control'
                                    ]
                                ),
                            ],
                            [
                                'label' => Yii::t('app', '属性'),
                                'attribute' => 'type',
                                'value' => function ($model, $key, $index, $column) {
                                    return ConfigTypeEnum::getValue($model->type);
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'type',
                                    ConfigTypeEnum::getMap(), [
                                        'prompt' => Yii::t('app', 'All'),
                                        'class' => 'form-control'
                                    ]
                                ),
                                'headerOptions' => ['class' => 'col-md-1'],
                            ],
                            [
                                'header' => Yii::t('app', '操作'),
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{edit} {status} {destroy}',
                                'buttons' => [
                                    'edit' => function ($url, $model, $key) {
                                        return Html::edit(['ajax-edit', 'id' => $model->id], [
                                            'data-toggle' => 'modal',
                                            'data-target' => '#ajaxModalLg',
                                        ]);
                                    },
                                    'status' => function ($url, $model, $key) {
                                        return Html::status($model->status);
                                    },
                                    'destroy' => function ($url, $model, $key) {
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
</div>