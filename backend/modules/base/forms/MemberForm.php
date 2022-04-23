<?php

namespace backend\modules\base\forms;

use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use common\models\rbac\AuthRole;
use common\models\backend\Member;

/**
 * Class MemberForm
 * @package backend\modules\base\models
 * @author YiiFrame <21931118@qq.com>
 */
class MemberForm extends Model
{
    public $id;
    public $password;
    public $username;
    public $mobile;
    public $realname;
    public $role_id;
    public $department_id;

    /**
     * @var \common\models\backend\Member
     */
    protected $member;

    /*
     * @var \common\models\backend\AuthItem
     */
    protected $authItemModel;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['password', 'username','realname', 'mobile'], 'required'],
            ['password', 'string', 'min' => 6],
            [
                ['role_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => AuthRole::class,
                'targetAttribute' => ['role_id' => 'id'],
            ],
            [['username'], 'isUnique'],
            [['role_id'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', '密码'),
            'username' => Yii::t('app', '用户名'),
            'realname' => Yii::t('app', '姓名'),
            'mobile' => Yii::t('app', '手机'),
            'role_id' => Yii::t('app', '角色'),
            'department_id' => Yii::t('app', '部门'),

        ];
    }

    /**
     * 加载默认数据
     */
    public function loadData()
    {
        if ($this->member = Yii::$app->services->backendMember->findByIdWithAssignment($this->id)) {
            $this->realname = $this->member->realname;
            $this->mobile = $this->member->mobile;
//            $this->username = $this->member->username;
            $this->password = $this->member->password_hash;
            $this->department_id = $this->member->department_id;

        } else {
            $this->member = new Member();
        }

        $this->role_id = $this->member->assignment->role_id ?? '';
    }

    /**
     * 场景
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'default' => ['username', 'password'],
            'generalAdmin' => array_keys($this->attributeLabels()),
        ];
    }

    /**
     * 验证用户名称
     */
    public function isUnique()
    {
        $member = Member::findOne(['username' => $this->username]);
        if ($member && $member->id != $this->id) {
            $this->addError('username', '用户名称已经被占用');
        }
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $member = $this->member;
            if ($member->isNewRecord) {
                $member->last_ip = '0.0.0.0';
                $member->last_time = time();
            }
//            $member->username = $this->username;
            $member->username = $this->mobile;
            $member->realname = $this->realname;
            $member->mobile = $this->mobile;
            $member->department_id = $this->department_id;
            $member->role_id = $this->role_id;
            // 验证密码是否修改
            if ($this->member->password_hash != $this->password) {
                $member->password_hash = Yii::$app->security->generatePasswordHash($this->password);;
            }

            if (!$member->save()) {
                $this->addErrors($member->getErrors());
                throw new NotFoundHttpException('用户编辑错误');
            }

            // 验证超级管理员
            if ($this->id == Yii::$app->params['adminAccount']) {
                $transaction->commit();

                return true;
            }

            // 角色授权
            Yii::$app->services->rbacAuthAssignment->assign([$this->role_id], $member->id, Yii::$app->id);

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();

            return false;
        }
    }
}
