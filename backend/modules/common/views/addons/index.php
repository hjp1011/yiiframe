<?php

use yii\grid\GridView;
use common\helpers\Url;
use common\helpers\Html;
use yiiframe\addonhelper\AddonHelper;

$this->title = Yii::t('app', '已安装');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="<?= Url::to(['index']) ?>"><?=Yii::t('app', '已安装')?></a></li>
                <li><a href="<?= Url::to(['local']) ?>"><?=Yii::t('app', '未安装')?></a></li>
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
//                            'fixedRightNumber' => 1,
                        ],
                        'columns' => [
                            [
                                'attribute' => 'icon',
                                'filter' => false, //不显示搜索框
                                'headerOptions' => ['class' => 'col-md-1'],
                                'value' => function ($model) {
                                    return Html::img(AddonHelper::getAddonIcon($model['name']), [
                                        'class' => 'img-rounded m-t-xs img-responsive',
                                        'width' => '64',
                                        'height' => '64',
                                    ]);
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'title',
                                // 'filter' => false, //不显示搜索框
                                'value' => function ($model) {
                                    $str = '<h5> ' . $model['title'] . '</h5>';
                                    $str .= "<small>" . $model['name'] . "</small>";
                                    return $str;
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'author',
                                'filter' => false, //不显示搜索框
                            ],
                            [
                                'attribute' => 'group',
                                'filter' => false, //不显示搜索框
                                'value' => function ($model) use ($addonsGroup) {
                                    return '<span class="label label-primary">' . $addonsGroup[$model->group]['title'] . '</span> ';
                                },
                                'format' => 'raw'
                            ],
                            [
                                'label' => Yii::t('app', '支持'),
                                'filter' => false, //不显示搜索框
                                'value' => function ($model) {
                                    $str = '';
                                    $model['is_setting'] == true && $str .= '<span class="label label-info">'.Yii::t('app', '全局设置').'</span> ';
                                    $model['is_rule'] == true && $str .= '<span class="label label-info">'.Yii::t('app', '嵌入规则').'</span> ';
                                    $model['is_merchant_route_map'] == true && $str .= '<span class="label label-info">'.Yii::t('app', '企业映射').'</span>';
                                    return $str;
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'brief_introduction',
                                'filter' => false, //不显示搜索框
                            ],
                            [
                                'attribute' => 'version',
                                'filter' => false, //不显示搜索框
                            ],
                            [
                                'header' => Yii::t('app', '操作'),
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{install} {upgrade} {edit} {status} {delete}',
                                'buttons' => [
                                    'install' => function ($url, $model, $key) {
                                        return Html::linkButton(['install', 'name' => $model->name, 'installData' => false],
                                            Yii::t('app', '更新'), [
                                                'onclick' => "rfTwiceAffirm(this, '确认更新配置吗？', '会重载模块的配置和权限, 更新后需要重新授权');return false;"
                                            ]);
                                    },
                                    'upgrade' => function ($url, $model, $key) {
                                        return Html::linkButton(['upgrade', 'name' => $model->name], Yii::t('app', '升级'), [
                                            'onclick' => "rfTwiceAffirm(this, '确认升级数据库吗？', '会执行更新数据库字段升级等功能');return false;",
                                        ]);
                                    },
                                    'edit' => function ($url, $model, $key) {
                                        return Html::edit(['ajax-edit', 'id' => $model->id],  [
                                            'data-toggle' => 'modal',
                                            'data-target' => '#ajaxModalLg',
                                        ]);
                                    },
                                    'status' => function ($url, $model, $key) {
                                        return Html::status($model->status);
                                    },
                                    'delete' => function ($url, $model, $key) {
                                        return Html::linkButton(['un-install', 'name' => $model->name], Yii::t('app', '卸载'), [
                                            'class' => 'btn btn-danger btn-sm',
                                            'onclick' => "rfTwiceAffirm(this, '确认卸载插件么？', '请谨慎操作,会删除插件相关的数据表');return false;",
                                        ]);
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
