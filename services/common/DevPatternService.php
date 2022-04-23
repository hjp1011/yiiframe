<?php

namespace services\common;

use Yii;
use common\components\Service;
use common\enums\DevPatternEnum;
use common\enums\AppEnum;

/**
 * 开发模式
 *
 * Class DevPatternService
 * @package services\common
 * @author YiiFrame <21931118@qq.com>
 */
class DevPatternService extends Service
{

    /**
     * 判断集团版
     *
     * @return bool
     */
    public function isGroup()
    {
        return Yii::$app->params['devPattern'] === DevPatternEnum::Group;
    }
    /**
     * 判断企业版
     *
     * @return bool
     */
    public function isEnterprise()
    {
        return Yii::$app->params['devPattern'] === DevPatternEnum::Enterprise;
    }
    /**
     * 判断多企业
     *
     * @return bool
     */
    public function isB2B2C()
    {
        return Yii::$app->params['devPattern'] === DevPatternEnum::B2B2C;
    }

    /**
     * @return bool
     */
    public function isB2C()
    {
        return Yii::$app->params['devPattern'] === DevPatternEnum::B2C;
    }

    /**
     * @return bool
     */
    public function isSAAS()
    {
        return Yii::$app->params['devPattern'] === DevPatternEnum::SAAS;
    }

    /**
     * 判断是否平台不可见
     *
     * @return bool
     */
    public function isNotPlatformFunction()
    {
        return ($this->isB2C() || ($this->isB2B2C() && Yii::$app->id == AppEnum::MERCHANT));
    }

    /**
     * 判断是否只有企业可用功能
     *
     * @return bool
     */
    public function isMerchantFunction()
    {
        return ($this->isB2B2C() && Yii::$app->id == AppEnum::MERCHANT);
    }

    public function get($id){
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->member->get($id);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendMember->get($id);
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return Yii::$app->memberService->member->get($id);
    }
    public function getMap(){
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->member->getMap();
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendMember->getMap();
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return Yii::$app->memberService->member->getMap();
    }

    public function getName($id){
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->member->getName($id);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendMember->getName($id);
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return Yii::$app->memberService->member->getName($id);
    }
    public function getNames($id){
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->member->getNames($id);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendMember->getNames($id);
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return Yii::$app->memberService->member->getNames($id);
    }
    public function getRoleTitle($id){
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->member->getRoleTitle($id);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendMember->getRoleTitle($id);
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return Yii::$app->services->backendMember->getRoleTitle($id);
    }
    //获取用户对象
    public function getMember($id)
    {
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->member->getMember($id);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendMember->getMember($id);
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return Yii::$app->memberService->member->getMember($id);

    }

    //获取角色下拉
    public function getRolesDropDown()
    {
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->services->rbacAuthRole->getDropDown(AppEnum::MERCHANT, true);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->rbacAuthRole->getDropDown(AppEnum::BACKEND, true);
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return Yii::$app->services->rbacAuthRole->getDropDown(AppEnum::BACKEND, true);
    }
    //获取部门下拉
    public function getDepartmentDropDown()
    {
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->department->getMapList();
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendDepartment->getMapList();
        else
            return Yii::$app->services->backendDepartment->getMapList();
    }
    //获取部门负责人用户ID
    public function getLeaderRoleId($member_id,$role_id)
    {
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->member->getLeaderRoleId($member_id,$role_id);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendMember->getLeaderRoleId($member_id,$role_id);
        else
            return Yii::$app->services->backendMember->getLeaderRoleId($member_id,$role_id);
    }

    public function findAll()
    {
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->member->findAll();
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendMember->findAll();
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return Yii::$app->memberService->member->findAll();
    }
    public function findById($id)
    {
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->member->findById($id);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendMember->findById($id);
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return Yii::$app->memberService->member->findById($id);
    }
    public function findByIdWithAssignment($id)
    {
        if (Yii::$app->services->devPattern->isGroup())
            return Yii::$app->merchantsService->member->findByIdWithAssignment($id);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return Yii::$app->services->backendMember->findByIdWithAssignment($id);
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return Yii::$app->memberService->member->findByIdWithAssignment($id);
    }
    public function getoneMember()
    {
        if (Yii::$app->services->devPattern->isGroup())
            return $this->hasOne(\addons\Merchants\common\models\Member::class, ['id' => 'member_id']);
        else if (Yii::$app->services->devPattern->isEnterprise())
            return $this->hasOne(\common\models\backend\Member::class, ['id' => 'member_id']);
        else if (Yii::$app->services->devPattern->isB2B2C()||Yii::$app->services->devPattern->isB2C()||Yii::$app->services->devPattern->isSAAS())
            return $this->hasOne(\addons\Member\common\models\Member::class, ['id' => 'member_id']);
    }
}