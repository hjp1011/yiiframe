<?php

use yiiframe\treegrid\TreeGrid;
use common\helpers\Html;
use common\helpers\Url;
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
                    <?= Html::create(['ajax-edit'], [
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModalLg',
                        'class'=>"btn btn-white btn-sm",
                    ]) ?>
                    <?php if(!empty(Yii::$app->debris->addonConfig('Weixin')['corp_id'])) {?>
                    <span class="btn btn-white btn-sm" onclick="getAllDepartment()"><i class="fa fa-cloud-download"></i>同步部门</span>
                    <?php }?>

                </div>
            </div>
            <div class="box-body table-responsive">
                <?= Treegrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'id',
                    'parentColumnName' => 'pid',
                    'parentRootValue' => '0', //first parentId value
                    'pluginOptions' => [
                        'initialState' => 'expanded',//expanded,collapsed
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
                            'attribute' => 'sort',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'col-md-1'],
                            'value' => function ($model, $key, $index, $column) {
                                return Html::sort($model->sort);
                            },
                        ],
                        'department_leader',
                        [
                            'attribute' => 'status',
                            'value' => function($model,$key,$index,$column){
                                return $model->status==1?'有效':'无效';
                            }
                        ],
                        [
                            'header' => Yii::t('app', '操作'),
                            'class' => 'yii\grid\ActionColumn',
                            'template' => ' {status} {edit} {delete}',
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

<script>
    // 同步所有用户id
    function getAllDepartment() {
        rfAffirm('同步中,请不要关闭当前页面');
        syncDepartmentid();
    }
    
    function syncDepartmentid() {
        $.ajax({
            type:"get",
            url:"<?= Url::to(['sync-all-departmentid'])?>",
            dataType: "json",
            data: {},
            success: function(data){
                syncDepartment('all');
            }
        });
    }

    // 同步用户资料
    function syncDepartment(type, page = 0, departmentids = null){
        $.ajax({
            type:"post",
            url:"<?= Url::to(['sync-department'])?>",
            dataType: "json",
            data: {type:type,page:page,departmentids:departmentids},
            success: function(data){
                if (parseInt(data.code) === 200 && data.data.page) {
                    syncDepartment(type, data.data.page);
                } else {
                    rfAffirm(data.message);
                    window.location.reload();
                }
            }
        });
    }
   
</script>