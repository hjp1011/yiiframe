<?php

namespace backend\modules\base\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use common\traits\Curd;
use common\models\backend\Department;
use common\helpers\ResultHelper;
use backend\controllers\BaseController;

/**
 * 企业分类
 *
 * Class CateController
 * @package addons\Merchants\backend\controllers
 * @author YiiFrame <21931118@qq.com>
 */
class DepartmentController extends BaseController
{
    use Curd;

    /**
     * @var Cate
     */
    public $modelClass = Department::class;

    /**
     * Lists all Tree models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = $this->modelClass::find()
            ->andWhere(['merchant_id' => \Yii::$app->user->identity->merchant_id])
            ->orderBy('sort asc, created_at asc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed|string|\yii\console\Response|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionAjaxEdit()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = $this->findModel($id);
        $model->pid = $request->get('pid', null) ?? $model->pid; // 父id
        $model->merchant_id = \Yii::$app->user->identity->merchant_id;

        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            return $model->save()
                ? $this->redirect(['index'])
                : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }

        return $this->renderAjax($this->action->id, [
            'model' => $model,
            'dropDown' => Yii::$app->services->backendDepartment->getDropDownForEdit(),
        ]);
    }
    /**
     * 获取全部id
     *
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function actionSyncAllDepartmentid()
    {
        $next_departmentid = Yii::$app->request->get('next_departmentid', '');
        try {
            list($total, $count, $nextDepartmentid) = Yii::$app->services->backendDepartment->syncAllDepartmentid($next_departmentid);
            return ResultHelper::json(200, '同步部门id完成', [
                'total' => $total,
                'count' => $count,
                'next_departmentid' => $nextDepartmentid,
            ]);
        } catch (\Exception $e) {
            return ResultHelper::json(422, $e->getMessage());
        }
    }

    /**
     * 开始同步数据
     *
     * @return array
     * @throws \EasyWork\Kernel\Exceptions\InvalidConfigException
     * @throws yii\db\Exception
     */
     public function actionSyncDepartment()
    {
        $request = Yii::$app->request;
        $type = $request->post('type', 'all');
        $page = $request->post('page', 0);
        // 全部同步
        if ($type == 'all' && !empty($models = Yii::$app->services->backendDepartment->getFollowListByPage($page))) {
            // 同步部门信息
            foreach ($models as $Department) {
                Yii::$app->services->backendDepartment->syncByDepartmentid($Department['department_id']);
            }
            return ResultHelper::json(200, '同步完成', [
                'page' => $page + 1
            ]);
        }
        return ResultHelper::json(200, '同步完成');
    }
    
}