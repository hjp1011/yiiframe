<?php

use common\helpers\Url;
use common\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('app', 'Menu');
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?php foreach ($cates as $cate) { ?>
                    <li><a href="<?= Url::to(['menu/index', 'cate_id' => $cate['id']]) ?>"> <?= Yii::t('app', $cate['title']) ?></a></li>
                <?php } ?>
                <li class="active"><a href="<?= Url::to(['menu-cate/index']) ?>"> <?=Yii::t('app', '菜单分类')?></a></li>
                <li class="pull-right">
                    <?= Html::create(['ajax-edit'],  [
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModalLg',
                    ]); ?>
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
                        'fixedNumber' => 2,
                        'fixedRightNumber' => 1,
                    ],
                        'columns' => [
                            'id',
                            [
                                'attribute' => 'title',
                                'value' => function ($model) {
                                    $str = !empty($model->addons_name) ? ' <span class="label label-warning">'.Yii::t('app', 'Addon').'</span>' : '';

                                    return Yii::t('app', $model->title . $str);
                                },
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'icon',
                                'value' => function ($model) {
                                    return '<i class="fa ' . $model->icon . '">';
                                },
                                'filter' => false,
                                'format' => 'raw',
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
                                'attribute' => 'is_default_show',
                                'value' => function ($model) {
                                    return Html::whether($model->is_default_show);
                                },
                                'filter' => false,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'addon_centre',
                                'value' => function ($model) {
                                    return Html::whether($model->addon_centre);
                                },
                                'filter' => false,
                                'format' => 'raw',
                            ],
                            [
                                'header' => Yii::t('app', '操作'),
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{ajax-edit} {status} {delete}',
                                'buttons' => [
                                    'ajax-edit' => function ($url, $model, $key) {
                                        return Html::edit(['ajax-edit', 'id' => $model->id], [
                                            'data-toggle' => 'modal',
                                            'data-target' => '#ajaxModalLg',
                                        ]);
                                    },
                                    'status' => function ($url, $model, $key) {
                                        return Html::status($model->status);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        if ($model->is_addon == \common\enums\WhetherEnum::DISABLED) {
                                            return Html::delete(['delete', 'id' => $model->id]);
                                        }

                                        return false;
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