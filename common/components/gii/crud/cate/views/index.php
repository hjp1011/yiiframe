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
use yiiframe\treegrid\TreeGrid;

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
                    <?= "<?= " ?> Html::create(['edit'],  [
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModalLg',
                    ])?>
                </div>
            </div>
            <div class="box-body table-responsive">
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>TreeGrid::widget([
        'dataProvider' => $dataProvider,
        'keyColumnName' => 'id',
        'parentColumnName' => 'pid',
        'parentRootValue' => '0', //first parentId value
        'pluginOptions' => [
            'initialState' => 'collapsed',
        ],
        'options' => [
            'class' => 'table table-hover',
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
            if($column->name=='title')
            echo "            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function (\$model, \$key, \$index, \$column) {
                    \$str = Html::tag('span', \$model->title, ['class' => 'm-l-sm']);
                    \$str .= Html::a(' <i class=\"icon ion-android-add-circle\"></i>', ['edit', 'pid' => \$model['id']], [
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModalLg',
                    ]);
                    return \$str;
                 }
             ],\n";
            else if($column->name=='sort')
                echo "            [
                'attribute' => 'sort',
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-md-1'],
                'value' => function (\$model, \$key, \$index, \$column) {
                    return Html::sort(\$model->sort);
                }
             ],\n";
            else echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
            [
                'header' => Yii::t('app', '操作'),
                'class' => 'yii\grid\ActionColumn',
                'template' => '{status} {edit} {delete}',
                'buttons' => [
                    'status' => function ($url, $model, $key) {
                        return Html::status($model->status);
                    },
                    'edit' => function ($url, $model, $key) {
                        return Html::edit(['edit', 'id' => $model->id], [
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModalLg',
                    ]);
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
