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
use yii\helpers\Json;
use common\traits\Curd;
use common\models\base\SearchModel;
use common\controllers\BaseController;
use common\helpers\ExcelHelper;
use <?= ltrim($generator->modelClass, '\\') ?>;
use <?= ltrim($generator->modelClass.'Cate', '\\') ?>;
use addons\Flow\common\models\Works;

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
            'relations' => ['member' => ['realname']], // 关联 member 表的 realname 字段
            'partialMatchAttributes' => ['title', 'member.realname'], // 模糊查询，注意 member.realname 为关联表的别名 表名.字段
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => $this->pageSize
        ]);

        $search = $params = Yii::$app->request->queryParams;
        $created_time = [];
        if (!empty($search['SearchModel']['created_at'])) {
            list($start, $end) = explode('/', $params['SearchModel']['created_at']);
            $start = strtotime($start);
            $end = strtotime($end);
            $created_time = ['between', $this->modelClass::tableName().'.created_at', $start, $end];
            unset($params['SearchModel']['created_at']);
        }
        $dataProvider = $searchModel->search($params);
        !empty($created_time)?$dataProvider->query->andWhere($created_time):$dataProvider->query->andWhere([$this->modelClass::tableName().'.merchant_id' => \Yii::$app->user->identity->merchant_id]);
        if (Yii::$app->user->identity->department_id != 0)//普通用户
            $dataProvider->query->andWhere([$this->modelClass::tableName().'.member_id' => Yii::$app->user->id]);
        else//管理员
            $dataProvider->query->andWhere([$this->modelClass::tableName().'.merchant_id' => \Yii::$app->user->identity->merchant_id]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'cates' => <?= $modelClass ?>Cate::getDropDown(),
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
        $id = Yii::$app->request->get('id', null);
        $model = $this->findModel($id);
        $model->covers = Json::decode($model->covers);
        foreach ($model->getNextStatuses() as $key => $nextStatus) {
            $radioList[$key] = $nextStatus['status']->getLabel();
        }
        $model->remind = 0;//默认0
        if ($model->load(Yii::$app->request->post())) {
            !empty($model->covers) && $model->covers = Json::encode($model->covers);
            return $model->save()? $this->redirect(['index']) : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }
        return $this->render('create', [
            'model' => $model,
            'cates' =>  <?= $modelClass ?>Cate::getDropDown(),
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
        $id = Yii::$app->request->get('id', null);
        $model = $this->findModel($id);
        $model->covers = Json::decode($model->covers);
        foreach ($model->getNextStatuses() as $key => $nextStatus) {
            $radioList[$key] = $nextStatus['status']->getLabel();
        }
        $model->remind = 0;
        if ($model->load(Yii::$app->request->post())) {
            !empty($model->covers) && $model->covers = Json::encode($model->covers);
            return $model->save() ? $this->redirect(['index']) : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }
        return $this->render('edit', [
            'model' => $model,
            'cates' => <?= $modelClass ?>Cate::getDropDown(),
        ]);
    }
    /**
    * 进度
    *
    * @return string
    * @throws \yii\web\NotFoundHttpException
    */
    public function actionAjaxApprove()
    {
        $id = Yii::$app->request->get('id', null);
        $model = $this->findModel($id);
        $radioList = [];
        foreach ($model->getNextStatuses() as $key => $nextStatus) {
            $radioList[$key] = $nextStatus['status']->getLabel();
        }
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            return $model->save() ? $this->redirect(['index']) : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }
        $status = explode('/', $model->status);
        $works = Works::find()->andWhere(['workflow_id' => $status[0], 'work_id' => $id])->one();
        return $this->renderAjax('ajax-approve', [
            'model' => $model,
            'radioList' => $radioList,
            'status' => $works->audit_id,
        ]);
    }
    /**
    * 删除
    *
    * @return string
    * @throws \yii\web\NotFoundHttpException
    */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->state == 'apply') {
        // 事务
        $transaction = Yii::$app->db->beginTransaction();
        try {
                Works::deleteAll(["workflow_id" => 'Repair', 'work_id' => $id]);
                $this->modelClass::deleteAll(["state" => 'apply', 'id' => $id]);
                $transaction->commit();
                return $this->message("删除成功", $this->redirect(['index']));
            } catch (\Exception $e) {
                $transaction->rollBack();
                return (Yii::$app->request->referrer);
            }
        }
        return $this->message(Yii::t('flow','Review has begin, cannot be deleted'), $this->redirect(['index']), 'error');
    }
    /**
    * 导出
    *
    * @return string
    * @throws \yii\web\NotFoundHttpException
    */
    public function actionExport()
    {
        $header = [
            [Yii::t('flow', 'Cate'), 'cate_id', 'selectd', <?= $modelClass ?>Cate::getDropDown()],
            [Yii::t('flow', 'Reason'), 'content'],
            [Yii::t('flow', 'Member'), 'member.realname'],
            [Yii::t('flow', 'Member'), 'created_at', 'date', 'Y-m-d'],
            [Yii::t('flow', 'Date'), 'state', 'function', function($model){
                $status=true;
                foreach ($model->getNextStatuses() as $key => $nextStatus) {
                    $status = false;
                }
                if($status) return $model->getWorkflowStatus()->getLabel();
                if(!$status) return \addons\Flow\common\enums\WorkflowEnum::getValue($model->state);
            }],
        ];
        $list = $this->modelClass::find()->select('*')
        ->andWhere(['merchant_id'=>\Yii::$app->user->identity->merchant_id])->with('member')->all();
        return ExcelHelper::exportData($list, $header);
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
