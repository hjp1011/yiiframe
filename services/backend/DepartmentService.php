<?php

namespace services\backend;

use Yii;
use common\enums\StatusEnum;
use common\helpers\ArrayHelper;
use common\components\Service;
use common\helpers\TreeHelper;
use common\models\backend\Department;

/**
 * Class Cate
 * @package addons\TinyShop\common\components\product
 * @author YiiFrame <21931118@qq.com>
 */
class DepartmentService extends Service
{
    /**
     * 获取下拉
     *
     * @param string $id
     * @return array
     */
    public function getDropDownForEdit($id = '')
    {
        $list = Department::find()
            ->where(['>=', 'status', StatusEnum::DISABLED])
            ->andFilterWhere(['merchant_id' => \Yii::$app->user->identity->merchant_id])
            ->andFilterWhere(['<>', 'id', $id])
            ->select(['id', 'title', 'pid', 'level'])
            ->orderBy('sort asc')
            ->asArray()
            ->all();

        $models = ArrayHelper::itemsMerge($list);
        $data = ArrayHelper::map(ArrayHelper::itemsMergeDropDown($models), 'id', 'title');

        return ArrayHelper::merge([0 => \Yii::t('app', '顶级分类')], $data);
    }

    /**
     * @return array
     */
    public function getMapList()
    {
        $models = ArrayHelper::itemsMerge($this->getList());
        return ArrayHelper::map(ArrayHelper::itemsMergeDropDown($models), 'id', 'title');
    }
    public function getMap()
    {
        return ArrayHelper::map($this->findAll(), 'id', 'title');
    }
    /**
     * @param string $pid
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getList()
    {
        return Department::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andFilterWhere(['merchant_id' => \Yii::$app->user->identity->merchant_id])
            ->orderBy('sort asc, id desc')
            ->asArray()
            ->all();
    }

    /**
     * 获取首页推荐
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findIndexBlock()
    {
        return Department::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->andWhere(['index_block_status' => StatusEnum::ENABLED])
            ->orderBy('sort asc, id desc')
            ->cache(60)
            ->asArray()
            ->all();
    }

    /**
     * 获取所有下级id
     *
     * @param $id
     * @return array
     */
    public function findChildIdsById($id)
    {
        if ($model = $this->findById($id)) {
            $tree = $model['tree'] .  TreeHelper::prefixTreeKey($id);
            $list = $this->getChilds($tree);

            return ArrayHelper::merge([$id], array_column($list, 'id'));
        }

        return [];
    }

    /**
     * 获取所有下级
     *
     * @param $tree
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getChilds($tree)
    {
        return Department::find()
            ->where(['like', 'tree', $tree . '%', false])
            ->andWhere(['>=', 'status', StatusEnum::DISABLED])
            ->asArray()
            ->all();
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null|Cate
     */
    public function findById($id)
    {
        return Department::find()
            ->where(['id' => $id])
            ->andWhere(['>=', 'status', StatusEnum::DISABLED])
            ->asArray()
            ->one();
    }
    public function findAll()
    {
        return Department::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->asArray()
            ->all();
    }
     /**
     * 同步所有Departmentid
     */
    public function syncAllDepartmentid($nextDepartmentid = null)
    {
        // 获取全部列表
        $department_array = Yii::$app->wechat->work->department->list()['department'];
        $Department_list = [];
        foreach ($department_array as $departments) {
            
            $Department_list[]=$departments['id'];

        }
        $Department_count = count($Department_list);
        $total_page = ceil($Department_count / 500);
        for ($i = 0; $i < $total_page; $i++) {
            $Department = array_slice($Department_list, $i * 500, 500);
            // 系统内的标签
            $system_Department = Yii::$app->services->backendDepartment->getListByDepartmentids($Department);
            $new_system_Department = ArrayHelper::arrayKey($system_Department, 'department_id');

            $add_Department = [];
            foreach ($Department as $departmentid) {
                if (empty($new_system_Department) || empty($new_system_Department[$departmentid])) {
                    $add_Department[] = [
                        Yii::$app->user->identity->merchant_id,
                        $departmentid,
                        time(),
                        time()
                    ];
                }
            }

            if (!empty($add_Department)) {
                // 批量插入数据
                $field = [
                    'merchant_id',
                    'department_id',
                    'created_at',
                    'updated_at',
                ];
                Yii::$app->db->createCommand()->batchInsert(Department::tableName(), $field, $add_Department)->execute();
            }

        }
        return [$Department_count, !empty($Department_list) ? $Department_count : 0, ''];
    }

    /**
     * 同步部门信息
     *
     * @param $departmentid
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function syncByDepartmentid($departmentid)
    {
        $result = Yii::$app->wechat->work->department->list()['department'];
        $model = Department::find()->where(['department_id' => $departmentid])->one();
        // $model->attributes = $result;
        foreach ($result as  $i=>$department) {
            if ($departmentid==$department['id']) {
                $model->title = $department['name'];
                $model->pid = $department['parentid'];
                $model->sort = $department['order'];
                // $model->department_leader = $department['department_leader'][0];
                $model->level = 1;
            }
        }   

        $model->save();
    }
    /**
     * @param $departmentid
     * @return array|null|\yii\db\ActiveRecord
     */
    public function findByDepartmentid($departmentid)
    {
        return Department::find()
            ->where(['department_id' => $departmentid])
            ->andFilterWhere(['merchant_id' => Yii::$app->user->identity->merchant_id])
            ->one();
    }

    /**
     * @param array $departmentids
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getListByDepartmentids(array $departmentids)
    {
        return Department::find()
            ->where(['in', 'department_id', $departmentids])
            ->andFilterWhere(['merchant_id' => Yii::$app->user->identity->merchant_id])
            ->select('department_id')
            ->asArray()
            ->all();
    }

    /**
     * @param int $page
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getFollowListByPage($page = 0)
    {
        return Department::find()
            ->where(['merchant_id' => Yii::$app->user->identity->merchant_id])
            ->offset(10 * $page)
            ->orderBy('department_id desc')
            ->limit(10)
            ->asArray()
            ->all();
    }
    
}