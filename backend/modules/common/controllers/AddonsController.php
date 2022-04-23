<?php

namespace backend\modules\common\controllers;


use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use common\traits\Curd;
use common\models\base\SearchModel;
use common\helpers\FileHelper;
use yiiframe\addonhelper\AddonHelper;
use common\models\common\Addons;
use common\helpers\ExecuteHelper;
use common\enums\AppEnum;
use common\interfaces\AddonWidget;
use backend\modules\common\forms\AddonsForm;
use backend\controllers\BaseController;
use yii\web\UnprocessableEntityHttpException;
use addons\Flow\common\models\Metadata;
use addons\Flow\common\models\Status;
use addons\Flow\common\models\Transition;
use addons\Flow\common\models\Workflow;
use addons\Flow\common\models\Works;

/**
 * Class AddonsController
 * @package merchant\modules\common\controllers
 * @author YiiFrame <21931118@qq.com>
 */
class AddonsController extends BaseController
{
    use Curd;

    /**
     * @var Addons
     */
    public $modelClass = Addons::class;

    /**
     * 首页
     *
     * @return mixed|string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel([
            'model' => Addons::class,
            'scenario' => 'default',
            'partialMatchAttributes' => ['title', 'name'], // 模糊查询
            'defaultOrder' => [
                'title_initial' => SORT_ASC,
            ],
            'pageSize' => $this->pageSize,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'addonsGroup' => Yii::$app->params['addonsGroup'],
        ]);
    }

    /**
     * 卸载
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUnInstall()
    {
        $name = Yii::$app->request->get('name');
        $request = Yii::$app->request;
        $addons = Addons::find()->select('*')
            ->where(['name' => $request->get('name')])
            ->one();
        if($addons->group =='approve') {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //卸载工作流
                Workflow::deleteAll(['id' => $request->get('name')]);
                Status::deleteAll(['workflow_id' => $request->get('name')]);
                Transition::deleteAll(['workflow_id' => $request->get('name')]);
                Metadata::deleteAll(['workflow_id' => $request->get('name')]);
                Works::deleteAll(['workflow_id' => $request->get('name')]);
                // 删除数据
                if ($model = Addons::findOne(['name' => $request->get('name')])) {
                    $model->delete();
                }
                // 进行卸载数据库
                if ($class = Yii::$app->services->addons->getConfigClass($name)) {
                    $uninstallClass = AddonHelper::getAddonRoot($name) . (new $class)->uninstall;
                    ExecuteHelper::map($uninstallClass, 'run', $model);
                }
                $transaction->commit();
                return $this->message(Yii::t('app', '卸载成功'), $this->redirect(['index']));
            } catch (\Exception $e) {
                $transaction->rollBack();
                return (Yii::$app->request->referrer);
            }
        }
        else {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model = Addons::findOne(['name' => $name])) {
                    $model->delete();
                }
                // 进行卸载数据库
                if ($class = Yii::$app->services->addons->getConfigClass($name)) {
                    $uninstallClass = AddonHelper::getAddonRoot($name) . (new $class)->uninstall;
                    ExecuteHelper::map($uninstallClass, 'run', $model);
                }
                $transaction->commit();
                return $this->message(Yii::t('app', '卸载成功'), $this->redirect(['index']));
            } catch (\Exception $e) {
                $transaction->rollBack();
                return (Yii::$app->request->referrer);
            }
        }
    }

    /**
     * 安装列表
     *
     * @return mixed|string
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionLocal()
    {
        return $this->render($this->action->id, [
            'list' => Yii::$app->services->addons->getLocalList(),
            'addonsGroup' => Yii::$app->params['addonsGroup'],
        ]);
    }

    /**
     * 安装
     *
     * @return mixed|string
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionInstall($installData = true)
    {
        $name = Yii::$app->request->get('name');
        $request = Yii::$app->request;
        if (!($class = Yii::$app->services->addons->getConfigClass($name))) {
            return $this->message(Yii::t('app', '实例化失败,插件不存在或检查插件名称'), $this->redirect(['index']), 'error');
        }

        ini_set("max_execution_time", 300);

        // 开启事务
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $config = new $class;
            $rootPath = AddonHelper::getAddonRootPath($name);

            $allAuthItem = [];
            $allMenu = [];
            $allCover = [];
            $removeAppIds = [];
            $defaultConfig = [];

            foreach ($config->appsConfig as $appId => $item) {
                $file = $rootPath . $item;

                if (!in_array($appId, array_keys(AppEnum::getMap()))) {
                    throw new NotFoundHttpException(Yii::t('app', '找不到应用'));
                }
                if (!file_exists($file)) {
                    throw new NotFoundHttpException(Yii::t('app', '未找到'). $appId .Yii::t('app', '应用文件'));
                }

                $appConfig = require $file;
                // 权限
                if (isset($appConfig['authItem']) && !empty($appConfig['authItem'])) {
                    $allAuthItem[$appId] = $appConfig['authItem'];
                }
                // 菜单
                if (isset($appConfig['menu']) && !empty($appConfig['menu'])) {
                    $allMenu[$appId] = $appConfig['menu'];
                }

                // 默认存储配置
                $defaultConfig[$appId] = $appConfig['config'] ?? [];
                // 菜单配置
                if (isset($defaultConfig[$appId]['menu']['location']) && $defaultConfig[$appId]['menu']['location'] == Addons::TYPE_DEFAULT) {
                    $cate = Yii::$app->services->menuCate->createByAddons($appId, $config->info, $defaultConfig[$appId]['menu']['icon']);
                    Yii::$app->services->menu->delByCate($cate);
                    Yii::$app->services->menu->createByAddons($appConfig['menu'], $cate);
                    // 移除菜单到应用中心列表
                    $removeAppIds[] = $appId;
                }
                // 入口
                if (isset($appConfig['cover']) && !empty($appConfig['cover'])) {
                    $allCover[$appId] = $appConfig['cover'];
                }
            }

            Yii::$app->services->rbacAuthItemChild->accreditByAddon($allAuthItem, $name, $installData);
            // 移除
            foreach ($removeAppIds as $removeAppId) {
                unset($allMenu[$removeAppId]);
            }

            Yii::$app->services->addonsBinding->create($allMenu, $allCover, $name);

            // 更新信息
            $model = Yii::$app->services->addons->update($name, $config, $defaultConfig);

            // 进行安装数据库
            if ($installData == true) {
                $installClass = AddonHelper::getAddonRoot($name) . $config->install;
                ExecuteHelper::map($installClass, 'run', $model);
            }

            //安装工作流
            $addons = \common\models\common\Addons::find()->select('*')
                ->where(['name' => $request->get('name')])
                ->one();
            if(Yii::$app->services->devPattern->isEnterprise()&&$addons->group =='approve'&&Yii::$app->request->get('installData')!='0') {
                //安装流程
                $model = new Workflow();
                $model->merchant_id = \Yii::$app->user->identity->merchant_id;
                $model->title = $request->get('title');
                $model->id = $request->get('name');
                $model->initial_status_id = 'apply';
                if (!$model->save()) {
                    throw new NotFoundHttpException(Yii::t('app', '安装流程失败'));
                }
                //初始化流程状态
                $list = ['apply' => '申请', 'audit' => '审核', 'agree' => '通过', 'refused' => '拒绝'];
                $i=0;
                foreach ($list as $id => $label) {
                    $status = new Status();
                    $status->workflow_id = Yii::$app->request->get('name');
                    $status->merchant_id = \Yii::$app->user->identity->merchant_id;
                    $status->label = $label;
                    $status->sort = ++$i;
                    $status->id = $id;
                    if (!$status->save()) {
                        throw new NotFoundHttpException(Yii::t('app', '初始化流程状态失败'));
                    }
                }
                //初始化工作流转
                $list = ['apply/audit', 'apply/refused', 'audit/agree', 'audit/refused'];
                foreach ($list as $value) {
                    $transition = new Transition();
                    $transition->workflow_id = Yii::$app->request->get('name');
                    $transition->merchant_id = \Yii::$app->user->identity->merchant_id;
                    $transition->start_status_id = explode('/', $value)[0];;
                    $transition->end_status_id = explode('/', $value)[1];
                    if (!$transition->save()) {
                        throw new NotFoundHttpException(Yii::t('app', '初始化工作流转失败'));
                    }
                }
            }
            $transaction->commit();

            return $this->message(Yii::t('app', '安装/更新成功'), $this->redirect(['index']));
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->message($e->getMessage(), $this->redirect(['index']), 'error');
        }
    }

    /**
     * 升级数据库
     *
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpgrade()
    {
        $name = Yii::$app->request->get('name');

        if (
            !($class = Yii::$app->services->addons->getConfigClass($name)) ||
            !($model = Yii::$app->services->addons->findByName($name))
        ) {
            return $this->message(Yii::t('app', '实例化失败,插件不存在或检查插件名称'), $this->redirect(['index']), 'error');
        }

        // 更新数据库
        $upgradeClass = AddonHelper::getAddonRoot($name) . (new $class)->upgrade;
//        var_dump($upgradeClass);
        if (!class_exists($upgradeClass)) {
            throw new NotFoundHttpException($upgradeClass . Yii::t('app', '未找到'));
        }

        /** @var AddonWidget $upgradeModel */
        $upgradeModel = new $upgradeClass;
        if (!method_exists($upgradeModel, 'run')) {
            throw new NotFoundHttpException($upgradeClass . Yii::t('app', 'run方法未找到'));
        }

        if (!isset($upgradeModel->versions)) {
            throw new NotFoundHttpException($upgradeClass . Yii::t('app', 'versions 属性未找到'));
        }

        $versions = $upgradeModel->versions;
        $count = count($versions);
        for ($i = 0; $i < $count; $i++) {
            // 验证版本号和更新
            if ($model->version == $versions[$i] && isset($versions[$i + 1])) {
                // 开启事务
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    $model->version = $versions[$i + 1];
                    $upgradeModel->run($model);
                    $model->save();
                    // 完成事务
                    $transaction->commit();
                } catch (\Exception $e) {
                    // 回滚事务
                    $transaction->rollBack();
                    if (YII_DEBUG) {
                        throw new UnprocessableEntityHttpException($e->getMessage());
                    }

                    return $this->message($e->getMessage(), $this->redirect(['index']), 'error');
                }
            }
        }

        return $this->message(Yii::t('app', '升级成功'), $this->redirect(['index']));
    }
    protected function findModel($id)
    {
        if (empty($id) || empty(($model = $this->modelClass::find()->andWhere(['id' => $id])->one()))) {
            $model = new $this->modelClass;
            return $model->loadDefaultValues();
        }
        return $model;
    }

}
