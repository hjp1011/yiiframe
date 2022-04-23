<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use common\helpers\Html;
use common\helpers\Url;
use kartik\daterange\DateRangePicker;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h2 style="font-size: 18px;padding-top: 0;margin-top: 0">
                    <i class="icon ion-android-apps"></i>
                    <?= "<?= " ?>Html::encode($this->title) ?>
                </h2>
                <div class="box-tools">
                    <?= "<?= " ?> Html::create(['export'], Yii::t('app','Export'), ['target' => '_blank']); ?>
                    <?= "<?= " ?> Html::create(['cate/index'], Yii::t('app','Cate')); ?>
                    <?= "<?= " ?> Html::create(['create'], Yii::t('app','Create')); ?>
                </div>
            </div>
            <div class="box-body table-responsive">
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-hover rf-table',
            'fixedNumber' => 2,
            'fixedRightNumber' => 1,
        ],
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            [
                'class' => 'yii\grid\SerialColumn',
                'visible' => false,
            ],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            //'" . $name . "',\n";
        }
    }
} else {
    $listFields = !empty($generator->listFields) ? $generator->listFields : [];
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (in_array($column->name, $listFields)) {
            if($column->name=='cate_id')
                echo "            [
                'attribute' => 'cate_id',
                'value' => 'cate.title',
                'filter' => Html::activeDropDownList(\$searchModel, 'cate_id', \$cates, [
                    'prompt' => Yii::t('app','All'),
                    'class' => 'form-control'
                    ]
                ),
            ],\n";
            elseif($column->name=='member_id')
                echo "            [
                'attribute' => 'member.realname',
                'filter' => Html::activeTextInput(\$searchModel, 'member.realname', [
                    'class' => 'form-control'
                    ]
                ),
                'headerOptions' => ['class' => 'col-md-1'],
            ],\n";
            elseif($column->name=='created_at')
                echo "            [
                     'attribute' => 'created_at',
                     'filter' => DateRangePicker::widget([
                     'name' => 'SearchModel[created_at]',
                     'value' => Yii::\$app->request->get('SearchModel')['created_at'],
                     'convertFormat' => true,
                     'pluginOptions' => [
                         'locale' => [
                             'format' => 'Y-m-d',
                             'separator' => '/',
                         ],
                    ]
                 ]),
                 'value' => function (\$model) {
                    return date('Y-m-d H:i:s', \$model->created_at);
                 },
            ],\n";
            elseif($column->name=='state')
                echo "            [
                    'attribute' => 'state',
                    'value' => function (\$model) {
                        \$status = true;
                        foreach (\$model->getNextStatuses() as \$key => \$nextStatus) {
                            \$status = false;
                        }
                        if (\$status) return \$model->getWorkflowStatus()->getLabel();
                        if (!\$status) return \addons\Flow\common\\enums\WorkflowEnum::getValue(\$model->state);
                    },
                    'filter' => Html::activeDropDownList(\$searchModel, 'state', \addons\Flow\common\\enums\WorkflowEnum::getMap(), [
                        'prompt' => Yii::t('app','All'),
                        'class' => 'form-control'
                    ]
                ),
            ],\n";
            else
                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', '操作'),
                'template' => '{approve} {edit} {delete}',
                'buttons' => [
                    'approve' => function ($url, $model, $key) {
                        return Html::edit(['ajax-approve', 'id' => $model->id], [
                        'class' => 'btn btn-warning btn-sm',
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModalLg',
                        ]);
                    },
                    'edit' => function ($url, $model, $key) {
                        return Html::edit(['edit', 'id' => $model->id]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::delete(['delete', 'id' => $model->id]);
                    },
                ]
            ]
    ]
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>
