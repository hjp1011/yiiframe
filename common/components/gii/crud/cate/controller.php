<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use common\traits\Curd;
use common\enums\StatusEnum;
use common\helpers\ArrayHelper;
use common\models\base\SearchModel;
use common\controllers\BaseController;
use <?= ltrim($generator->modelClass, '\\') ?>;

/**
* <?= $modelClass . "\n" ?>
*
* Class <?= $controllerClass . "\n" ?>
* @package <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) . "\n" ?>
*/
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    use Curd;

    /**
    * @var <?= $modelClass . "\n" ?>
    */
    public $modelClass = <?= $modelClass ?>::class;


    /**
    * 首页
    *
    * @return string
    * @throws \yii\web\NotFoundHttpException
    */
    public function actionIndex()
    {
        $searchModel = new SearchModel([
            'model' => $this->modelClass,
            'scenario' => 'default',
            'partialMatchAttributes' => [], // 模糊查询，注意 member.realname 为关联表的别名 表名.字段
            'defaultOrder' => [
                'sort' => SORT_ASC,
                'id' => SORT_DESC
            ],
            'pageSize' => $this->pageSize
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['merchant_id' => \Yii::$app->user->identity->merchant_id]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
    * 编辑
    *
    * @return string
    * @throws \yii\web\NotFoundHttpException
    */
    public function actionEdit()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = $this->findModel($id);
        $model->pid = $request->get('pid', null) ?? $model->pid; // 父id

        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            return $model->save()
            ? $this->redirect(['index'])
            : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }

        return $this->renderAjax($this->action->id, [
            'model' => $model,
            'cateDropDownList' => $this->modelClass::getDropDownForEdit($id),
        ]);
    }
    /**
    * 创建
    *
    * @return string
    * @throws \yii\web\NotFoundHttpException
    */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = $this->findModel($id);
        $model->pid = $request->get('pid', null) ?? $model->pid; // 父id

        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            return $model->save()
            ? $this->redirect(['index'])
            : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }

        return $this->renderAjax($this->action->id, [
            'model' => $model,
            'cateDropDownList' => $this->modelClass::getDropDownForEdit($id),
        ]);
    }


    protected function findModel($id)
    {
        if (empty($id) || empty(($model = $this->modelClass::findOne(['id' => $id, 'merchant_id' => \Yii::$app->user->identity->merchant_id])))) {
            $model = new $this->modelClass;
            return $model->loadDefaultValues();
        }
        return $model;
    }


}
