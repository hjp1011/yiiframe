<?php

use common\helpers\Html;
use common\helpers\ImageHelper;
use common\enums\MemberAuthEnum;
use yii\grid\GridView;

$this->title = Yii::t('app', '用户管理');
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
                    <?= Html::create(['ajax-edit'],[
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModalLg',
                    ]); ?>
                </div>
            </div>
            <div class="box-body table-responsive">
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
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
                        [
                            'attribute' => 'head_portrait',
                            'value' => function ($model) {
                                return Html::img(ImageHelper::defaultHeaderPortrait(Html::encode($model->head_portrait)),
                                    [
                                        'class' => 'img-circle rf-img-md img-bordered-sm',
                                    ]);
                            },
                            'filter' => false,
                            'format' => 'raw',
                        ],
                        'username',
                        'realname',
                        'department.title',
                        'mobile',
                        [
                            'label' => Yii::t('app', '角色'),
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                if ($model->id == Yii::$app->params['adminAccount']) {
                                    return Html::tag('span', Yii::t('app', '超级管理员'), ['class' => 'label label-success']);
                                } else {
                                    if (isset($model->assignment->role->title)) {
                                        return Html::tag('span', $model->assignment->role->title, ['class' => 'label label-primary']);
                                    } else {
                                        return Html::tag('span', Yii::t('app', '未授权'), ['class' => 'label label-default']);
                                    }
                                }
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => Yii::t('app', '最后登陆'),
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                return Yii::t('app', 'IP').':'. $model->last_ip . '<br>' .
                                    Yii::t('app', '时间').':'. Yii::$app->formatter->asDatetime($model->last_time) . '<br>' .
                                    Yii::t('app', '访问次数').':'. $model->visit_count;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'header' => Yii::t('app', '操作'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{account} {binding} {edit} {destroy}',
                            'contentOptions' => ['class' => 'text-align-center'],
                            'buttons' => [
                                'account' => function ($url, $model, $key) {
                                    return Html::a(Yii::t('app', '密码'), ['ajax-edit', 'id' => $model->id], [
                                            'data-toggle' => 'modal',
                                            'data-target' => '#ajaxModalLg',
                                            'class' => 'blue'
                                        ]) . '<br>';
                                },
//                                'binding' => function ($url, $model, $key) {
//                                    if (!empty($model->authWechat)) {
//                                        return Html::a(Yii::t('app', '解绑'), ['un-bind', 'id' => $model->id, 'type' => MemberAuthEnum::WECHAT], [
//                                                'class' => 'cyan',
//                                            ]) . '<br>';
//                                    } else {
//                                        return Html::a(Yii::t('app', '绑定'), ['binding', 'id' => $model->id, 'type' => MemberAuthEnum::WECHAT], [
//                                                'class' => 'cyan',
//                                                'data-fancybox' => 'gallery',
//                                            ]) . '<br>';
//                                    }
//                                },
                                'edit' => function ($url, $model, $key) {
                                    return Html::a(Yii::t('app', '编辑'), ['edit', 'id' => $model->id], [
                                            'class' => 'purple'
                                        ]) . '<br>';
                                },
                                'destroy' => function ($url, $model, $key)  {
                                    if ($model->id != Yii::$app->params['adminAccount']) {
                                        return Html::a(Yii::t('app', '删除'), ['destroy', 'id' => $model->id], [
                                                'class' => 'red',
                                            ]);
                                    }

                                    return '';
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
