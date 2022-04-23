<?php

namespace services;

use common\components\Service;

/**
 * Class Application
 *
 * @package services
 * @property \services\merchant\MerchantService $merchant 企业
 * @property \services\backend\BackendService $backend 系统
 * @property \services\backend\MemberService $backendMember 管理员
 * @property \services\backend\MemberAuthService $backendMemberAuth 管理员第三方绑定

 * @property \services\api\AccessTokenService $apiAccessToken Api授权key
 * @property \services\merapi\AccessTokenService $merapiAccessToken 企业Api授权key

 * @property \services\common\MenuService $menu 菜单
 * @property \services\common\MenuCateService $menuCate 菜单分类
 * @property \services\common\DevPatternService $devPattern 开发模式
 * @property \services\common\AddonsService $addons 插件
 * @property \services\common\AddonsConfigService $addonsConfig 插件配置
 * @property \services\common\AddonsBindingService $addonsBinding 插件菜单入口
 * @property \services\common\AuthService $auth 权限验证
 * @property \services\common\ConfigService $config 基础配置
 * @property \services\common\ConfigCateService $configCate 基础配置分类
 * @property \services\common\MiniProgramLiveService $miniProgramLive 小程序直播
 * @property \services\rbac\AuthItemService $rbacAuthItem 权限
 * @property \services\rbac\AuthItemChildService $rbacAuthItemChild 授权的权限
 * @property \services\rbac\AuthRoleService $rbacAuthRole 角色
 * @property \services\rbac\AuthAssignmentService $rbacAuthAssignment 授权
 *
 * @author YiiFrame <21931118@qq.com>
 */
class Application extends Service
{
    /**
     * @var array
     */
    public $childService = [
        /** ------ 系统 ------ **/
        'backend' => 'services\backend\BackendService',
        'backendMember' => 'services\backend\MemberService',
        'backendMemberAuth' => 'services\backend\MemberAuthService',
        'backendDepartment' => 'services\backend\DepartmentService',
        'backendReport' => 'services\backend\ReportService',
        /** ------ 企业 ------ **/
        'merchant' => 'services\merchant\MerchantService',

        /** ------ api ------ **/
        'apiAccessToken' => [
            'class' => 'services\api\AccessTokenService',
            'cache' => false, // 启用缓存到缓存读取用户信息
            'timeout' => 720, // 缓存过期时间，单位秒
        ],
        /** ------ merapi ------ **/
        'merapiAccessToken' => [
            'class' => 'services\merapi\AccessTokenService',
            'cache' => false, // 启用缓存到缓存读取用户信息
            'timeout' => 720, // 缓存过期时间，单位秒
        ],
        /** ------ 公用部分 ------ **/
        'menu' => 'services\common\MenuService',
        'menuCate' => 'services\common\MenuCateService',
        'config' => 'services\common\ConfigService',
        'configCate' => 'services\common\ConfigCateService',
        'addons' => 'services\common\AddonsService',
        'addonsConfig' => 'services\common\AddonsConfigService',
        'addonsBinding' => 'services\common\AddonsBindingService',
        'auth' => 'services\common\AuthService',
        'devPattern' => 'services\common\DevPatternService',
        'miniProgramLive' => 'services\common\MiniProgramLiveService',

        /** ------ rbac ------ **/
        'rbacAuthItem' => 'services\rbac\AuthItemService',
        'rbacAuthItemChild' => 'services\rbac\AuthItemChildService',
        'rbacAuthRole' => 'services\rbac\AuthRoleService',
        'rbacAuthAssignment' => 'services\rbac\AuthAssignmentService',

    ];
}