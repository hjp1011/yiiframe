<?php

namespace services\common;

use Yii;
use common\helpers\Auth;
use common\helpers\ArrayHelper;
use common\enums\StatusEnum;
use common\components\Service;
use common\enums\WhetherEnum;
use common\models\common\MenuCate;

/**
 * Class MenuCateService
 * @package services\common
 * @author YiiFrame <21931118@qq.com>
 */
class MenuCateService extends Service
{
    /**
     * @param string $addons_name 插件名称
     */
    public function delByAddonsName($addons_name)
    {
        MenuCate::deleteAll(['addons_name' => $addons_name]);
    }

    /**
     * @param $title
     * @param $icon
     * @return MenuCate
     */
    public function createByAddons($appId, array $info, $icon)
    {
        MenuCate::deleteAll(['app_id' => $appId, 'addons_name' => $info['name']]);

        $model = new MenuCate();
        $model->app_id = $appId;
        $model->addons_name = $info['name'];
        $model->is_addon = WhetherEnum::ENABLED;
        $model->title = $info['title'];
        $model->icon = $icon;
        $model->save();

        return $model;
    }

    /**
     * 查询 - 获取授权成功的全部分类
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getOnAuthList()
    {
        $models = $this->findAll();
        foreach ($models as $key => $model) {
            if ($model['is_addon'] == WhetherEnum::DISABLED && !Auth::verify('cate:' . $model['id'])) {
                unset($models[$key]);
            }

            if ($model['is_addon'] == WhetherEnum::ENABLED && !Auth::verify($model['addons_name'])) {
                unset($models[$key]);
            }

            if ($model['app_id'] == 'backend'&&$model['addons_name']=='Flow'&&Yii::$app->services->devPattern->isGroup()) {
                unset($models[$key]);
            }
        }
        return $models;
    }

    /**
     * 编辑 - 获取正常分类Map列表
     *
     * @return array
     */
    public function getDefaultMap($app_id)
    {
        return ArrayHelper::map($this->findDefault($app_id), 'id', 'title');
    }

    /**
     * 编辑 - 获取正常的分类
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findDefault($app_id)
    {
        return MenuCate::find()
             ->where(['addon_centre' => StatusEnum::DISABLED])
            ->andWhere(['app_id' => $app_id])
            ->andWhere(['>=', 'status', StatusEnum::DISABLED])
            ->orderBy('sort asc')
            ->asArray()
            ->all();
    }

    /**
     * 查询 - 获取全部分类
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findAll()
    {
        $cates = MenuCate::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andWhere(['app_id' => Yii::$app->id])
            ->orderBy('sort asc, id asc')
            ->asArray()
            ->all();
        $menus = [];
        $m=0;$n=0;$s=0;
        if (Yii::$app->id == 'merchant') {
            $lists = \addons\Merchants\common\models\Addons::find()
                ->select(['title', 'name', 'group'])
                ->where(['merchant_id' => \Yii::$app->user->identity->merchant_id])
                ->asArray()
                ->all();
            foreach ($cates as $i => &$cate) {
                if($cate['title']=='应用中心') $m=$i;
                if($cate['addons_name']=='Merchants') $n=$i;
                if($cate['addons_name']=='TinyShop') $s=$i;
                foreach ($lists as $j => $list) {
                    if ($cate['addons_name'] == $list['name'])
                        $menus[] = $cates[$i];
                }
            }
//            $menus[]=$cates[$s];
            $menus[]=$cates[$n];
            $menus[]=$cates[$m];
        }
        else $menus = $cates;
        return $menus;
    }

    /**
     * @param $id
     * @return MenuCate|null
     */
    public function findById($id)
    {
        return MenuCate::findOne($id);
    }

    /**
     * 获取首个显示的分类
     *
     * @return false|null|string
     */
    public function findFirstId($app_id)
    {
        return MenuCate::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andWhere(['app_id' => $app_id])
            ->orderBy('sort asc')
            ->select(['id'])
            ->scalar();
    }
}