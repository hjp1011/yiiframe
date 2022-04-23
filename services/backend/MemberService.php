<?php

namespace services\backend;

use Yii;
use common\enums\StatusEnum;
use common\helpers\ArrayHelper;
use common\components\Service;
use common\models\rbac\AuthRole;
use common\models\backend\Member ;

/**
 * Class MemberService
 * @package services\backend
 * @author YiiFrame <21931118@qq.com>
 */
class MemberService extends Service
{
    protected $member;

    /**
     * @param Member $member
     */
    public function set(Member $member)
    {
        $this->member = $member;
        return $this;
    }

    /**
     * @param $id
     * @return array|Member|\yii\db\ActiveRecord|null
     */
    public function get($id)
    {
        if (!$this->member || $this->member['id'] != $id) {
            $this->member = $this->findById($id);
        }

        return $this->member;
    }
    //获取用户名
    public function getName($id)
    {
        return Member::findOne($id)->realname;
    }
    //获取多个用户名
    public function getNames($ids = [])
    {
        $str = '';
        foreach ($ids as $id){
            $member =  Member::findOne($id);
            if($member) $str .= $member->realname.' ';
        }
        return $str;
    }
    //获取用户对象
    public function getMember($id)
    {
        return Member::findOne($id);
    }
    //获取角色名称
    public function getRoleTitle($id)
    {
        return AuthRole::findOne($id)->title;
    }
    //获取部门负责人用户ID
    public function getLeaderRoleId($member_id,$role_id)
    {
        $department_id = Member::findOne($member_id)->department_id;
        return Member::find()->where(['department_id'=>$department_id,'role_id'=>$role_id])->scalar();
    }
    /**
     * @return array
     */
    public function getMap()
    {
        return ArrayHelper::map($this->findAll(), 'id', 'realname');
    }
    /**
     * 记录访问次数
     *
     * @param Member $member
     */
    public function lastLogin(Member $member)
    {
        // 记录访问次数
        $member->visit_count += 1;
        $member->last_time = time();
        $member->last_ip = Yii::$app->request->getUserIP();
        $member->save();
    }
    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findAll()
    {
        return Member::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->asArray()
            ->all();
    }
    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findById($id)
    {
        return Member::find()
            ->where(['id' => $id, 'status' => StatusEnum::ENABLED])
            ->one();
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */
    public function findByIdWithAssignment($id)
    {
        return Member::find()
            ->where(['id' => $id])
            ->with('assignment')
            ->one();
    }


}