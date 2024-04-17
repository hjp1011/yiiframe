<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use api\controllers\OnAuthController;
use common\helpers\ArrayHelper;
use common\helpers\Auth;
use common\helpers\Url;
use yiiframe\plugs\models\Addons;
use common\models\rbac\AuthItemChild;
use addons\News\common\models\Cate;


/**
 * 登录接口
 *
 * Class SiteController
 * @author 古月 <21931118@qq.com>
 */
class ApplicationController extends OnAuthController
{
    public $modelClass = '';

    /**
     * 不用进行登录验证的方法
     *
     * 例如： ['index', 'update', 'create', 'view', 'delete']
     * 默认全部需要验证
     *
     * @var array
     */
    protected $authOptional = ['index', 'personal'];

    /**
     * 登录根据用户信息返回accessToken
     *
     * @return array|bool
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        //所有模块
        $addons = Addons::find()
            ->select(['title','title_initial', 'name', 'icon', 'group'])
            ->where(['not in', 'group', ['services', 'plug', 'personal','activity']])
            ->orderBy('title_initial asc' )
            ->asArray()
            ->all();
        //已安装模块
        $models = [];
        if(Yii::$app->user->identity){//已登陆
            if (Yii::$app->user->identity->role_id == Yii::$app->params['adminAccount'])//超级管理员
                $models = $addons;
            else
            foreach ($addons as $i => &$model) {
                    //已授权模块
                    $items = AuthItemChild::find()
                        ->select('*')
                        ->where(['addons_name'=>$model['name'],'role_id'=>Yii::$app->user->identity->role_id])
                        ->one();
                    if ($items)
                        $models[] = $addons[$i];
            }
        }
        // 创建分类数组
        $groups = array_keys(\yiiframe\plugs\enums\GroupEnum::getMap());
        $addons = [];
        foreach ($groups as $group) {
            !isset($addons[$group]) && $addons[$group] = [];
        }
        // 模块分类插入
        foreach ($models as $record) {
            $addons[$record['group']][] = $record;
        }
        // 删除空模块分类
        foreach ($addons as $key => $vlaue) {
            if (empty($vlaue)) {
                unset($addons[$key]);
            }
        }
        $menu = [];
        $i = 0;
        foreach ($addons as $key => $addon) {
            $menu[$i]['title'] = \yiiframe\plugs\enums\GroupEnum::getMap()[$key]['title'];
            if ($key == 'knowledge') {
                $cates = Cate::find()->select(['id', 'title', 'icon'])->where(['merchant_id' => Yii::$app->user->identity->merchant_id])->orderBy('sort')->asArray()->all();
                foreach ($cates as &$cate) {
                    $cate['name'] = 'News';
                    $cate['group'] = 'News';
                    $cate['url'] = '/pages/application/' . $cate['name'] . '/index?cate_id=' . $cate['id'] . '&title=' . $cate['title'];
                }
                $menu[$i]['list'] = $cates;
            } else {

                foreach ($addon as &$sub) {
                    $sub['url'] = '/pages/application/' . $sub['name'] . '/index';
                }
                $menu[$i]['list'] = $addon;

            }
            $i++;
        }
        return $menu;

    }

    public function actionPersonal()
    {
        //所有模块
        $addons = Addons::find()
            ->select(['title','title_initial', 'name', 'icon', 'group'])
            ->where(['group' => 'personal'])
            ->orderBy('title_initial asc' )
            ->asArray()
            ->all();

        $models = [];

        foreach ($addons as $i => &$model) {
            //已授权模块
            $items = AuthItemChild::find()
                ->select('*')
                ->where(['addons_name'=>$model['name'],'role_id'=>Yii::$app->user->identity->role_id])
                ->one();
            if ($items)
                $models[] = $addons[$i];
        }
        // 创建分类数组
        $groups = array_keys(\yiiframe\plugs\enums\GroupEnum::getMap());
        $addons = [];
        foreach ($groups as $group) {
            !isset($addons[$group]) && $addons[$group] = [];
        }
        // 模块分类插入
        foreach ($models as $record) {
            $addons[$record['group']][] = $record;
        }
        // 删除空模块分类
        foreach ($addons as $key => $vlaue) {
            if (empty($vlaue)) {
                unset($addons[$key]);
            }
        }
        $menu = [];
        $i = 0;
        foreach ($addons as $key => $addon) {
            $menu[$i]['title'] = \yiiframe\plugs\enums\GroupEnum::getMap()[$key]['title'];

            foreach ($addon as &$sub) {
                $sub['url'] = '/pages/application/' . $sub['name'] . '/index';
                $sub['num'] = 0;
            }
            $menu[$i]['list'] = $addon;

            $i++;
        }
        if($menu) return $menu[0];
        else return [];
    }

    /**
     * 权限验证
     *
     * @param string $action 当前的方法
     * @param null $model 当前的模型类
     * @param array $params $_GET变量
     * @throws \yii\web\BadRequestHttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        // 方法名称
        if (in_array($action, ['delete'])) {
            throw new \yii\web\BadRequestHttpException('权限不足');
        }
    }
}
