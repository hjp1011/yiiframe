<?php

use yii\db\Migration;

class m210817_163345_rbac_auth_item_child extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%rbac_auth_item_child}}', [
            'role_id' => "int(11) unsigned NOT NULL DEFAULT '0' COMMENT '角色id'",
            'item_id' => "int(10) unsigned NOT NULL DEFAULT '0' COMMENT '权限id'",
            'name' => "varchar(64) NOT NULL DEFAULT '' COMMENT '别名'",
            'app_id' => "varchar(20) NOT NULL DEFAULT '' COMMENT '类别'",
            'is_addon' => "tinyint(1) unsigned NULL DEFAULT '0' COMMENT '是否插件'",
            'addons_name' => "varchar(100) NULL DEFAULT '' COMMENT '插件名称'",
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统_授权角色权限表'");
        
        /* 索引设置 */
        $this->createIndex('role_id','{{%rbac_auth_item_child}}','role_id',0);
        $this->createIndex('item_id','{{%rbac_auth_item_child}}','item_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'1','name'=>'base','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'2','name'=>'/base/member/personal','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'7','name'=>'/common/config/update-info','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'11','name'=>'/common/config/*','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'14','name'=>'/common/menu/*','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'17','name'=>'backendMember','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'20','name'=>'/base/member/index','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'25','name'=>'/base/auth-item/index','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'29','name'=>'/base/auth-role/index','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'3','name'=>'/base/member/up-password','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'6','name'=>'/common/config/edit-all','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'10','name'=>'commonConfig','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'12','name'=>'/common/config-cate/*','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'15','name'=>'/common/menu-cate/*','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'18','name'=>'baseAuthItem','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'21','name'=>'/base/member/ajax-edit','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'26','name'=>'/base/auth-item/ajax-edit','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'30','name'=>'/base/auth-role/edit','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'4','name'=>'/main/clear-cache','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'5','name'=>'cate:1','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'8','name'=>'commonFunction','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'13','name'=>'commonMenu','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'19','name'=>'basenAuthRole','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'22','name'=>'/base/member/destroy','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'27','name'=>'/base/auth-item/delete','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'31','name'=>'/base/auth-role/delete','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'16','name'=>'backendMemberAuth','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'24','name'=>'/base/member/ajax-update','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'28','name'=>'/base/auth-item/ajax-update','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'32','name'=>'/base/auth-role/ajax-update','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'9','name'=>'/common/addons/*','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'23','name'=>'/base/member/edit','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'33','name'=>'/common/system/info','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        $this->insert('{{%rbac_auth_item_child}}',['role_id'=>'1','item_id'=>'34','name'=>'cate:2','app_id'=>'backend','is_addon'=>'0','addons_name'=>'']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%rbac_auth_item_child}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

