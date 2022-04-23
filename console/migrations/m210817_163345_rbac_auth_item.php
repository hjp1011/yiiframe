<?php

use yii\db\Migration;

class m210817_163345_rbac_auth_item extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%rbac_auth_item}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'name' => "varchar(64) NOT NULL DEFAULT '' COMMENT '别名'",
            'title' => "varchar(200) NULL DEFAULT '' COMMENT '标题'",
            'app_id' => "varchar(20) NOT NULL DEFAULT '' COMMENT '应用'",
            'addons_name' => "varchar(200) NULL DEFAULT '' COMMENT '插件名称'",
            'pid' => "int(10) NULL DEFAULT '0' COMMENT '父级id'",
            'level' => "int(5) NULL DEFAULT '1' COMMENT '级别'",
            'is_addon' => "tinyint(1) unsigned NULL DEFAULT '0' COMMENT '是否插件'",
            'sort' => "int(10) NULL DEFAULT '9999' COMMENT '排序'",
            'tree' => "varchar(500) NULL DEFAULT '' COMMENT '树'",
            'status' => "tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态[-1:删除;0:禁用;1启用]'",
            'created_at' => "int(11) NULL DEFAULT '0'",
            'updated_at' => "int(11) NULL DEFAULT '0'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='系统_权限表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%rbac_auth_item}}',['id'=>'1','name'=>'base','title'=>'系统基础','app_id'=>'backend','addons_name'=>'','pid'=>'0','level'=>'1','is_addon'=>'0','sort'=>'0','tree'=>'tr_0 ','status'=>'1','created_at'=>'1582376897','updated_at'=>'1582376897']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'2','name'=>'/base/member/personal','title'=>'个人信息','app_id'=>'backend','addons_name'=>'','pid'=>'1','level'=>'2','is_addon'=>'0','sort'=>'0','tree'=>'tr_0 tr_1 ','status'=>'1','created_at'=>'1582376897','updated_at'=>'1582376897']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'3','name'=>'/base/member/up-password','title'=>'修改密码','app_id'=>'backend','addons_name'=>'','pid'=>'1','level'=>'2','is_addon'=>'0','sort'=>'1','tree'=>'tr_0 tr_1 ','status'=>'1','created_at'=>'1582376897','updated_at'=>'1582376897']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'4','name'=>'/main/clear-cache','title'=>'清理缓存','app_id'=>'backend','addons_name'=>'','pid'=>'1','level'=>'2','is_addon'=>'0','sort'=>'2','tree'=>'tr_0 tr_1 ','status'=>'1','created_at'=>'1582376897','updated_at'=>'1582376897']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'5','name'=>'cate:1','title'=>'系统管理','app_id'=>'backend','addons_name'=>'','pid'=>'0','level'=>'1','is_addon'=>'0','sort'=>'2','tree'=>'tr_0 ','status'=>'1','created_at'=>'1582376900','updated_at'=>'1582376900']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'6','name'=>'/common/config/edit-all','title'=>'站点设置','app_id'=>'backend','addons_name'=>'','pid'=>'5','level'=>'2','is_addon'=>'0','sort'=>'1','tree'=>'tr_0 tr_38 ','status'=>'1','created_at'=>'1582376900','updated_at'=>'1616341724']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'7','name'=>'/common/config/update-info','title'=>'数据保存','app_id'=>'backend','addons_name'=>'','pid'=>'6','level'=>'3','is_addon'=>'0','sort'=>'0','tree'=>'tr_0 tr_38 tr_39 ','status'=>'1','created_at'=>'1582376900','updated_at'=>'1582376900']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'8','name'=>'commonFunction','title'=>'系统功能','app_id'=>'backend','addons_name'=>'','pid'=>'5','level'=>'2','is_addon'=>'0','sort'=>'2','tree'=>'tr_0 tr_38 ','status'=>'1','created_at'=>'1582376900','updated_at'=>'1616341727']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'9','name'=>'/common/addons/*','title'=>'应用管理','app_id'=>'backend','addons_name'=>'','pid'=>'5','level'=>'2','is_addon'=>'0','sort'=>'4','tree'=>'tr_0 tr_38 ','status'=>'1','created_at'=>'1582376900','updated_at'=>'1616341734']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'10','name'=>'commonConfig','title'=>'配置管理','app_id'=>'backend','addons_name'=>'','pid'=>'8','level'=>'3','is_addon'=>'0','sort'=>'1','tree'=>'tr_0 tr_38 tr_41 ','status'=>'1','created_at'=>'1582376901','updated_at'=>'1616337636']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'11','name'=>'/common/config/*','title'=>'配置列表','app_id'=>'backend','addons_name'=>'','pid'=>'10','level'=>'4','is_addon'=>'0','sort'=>'0','tree'=>'tr_0 tr_38 tr_41 tr_51 ','status'=>'1','created_at'=>'1582376901','updated_at'=>'1616337661']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'12','name'=>'/common/config-cate/*','title'=>'配置分类','app_id'=>'backend','addons_name'=>'','pid'=>'10','level'=>'4','is_addon'=>'0','sort'=>'1','tree'=>'tr_0 tr_38 tr_41 tr_51 ','status'=>'1','created_at'=>'1582376901','updated_at'=>'1616337705']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'13','name'=>'commonMenu','title'=>'菜单管理','app_id'=>'backend','addons_name'=>'','pid'=>'8','level'=>'3','is_addon'=>'0','sort'=>'2','tree'=>'tr_0 tr_38 tr_41 ','status'=>'1','created_at'=>'1582376901','updated_at'=>'1616337808']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'14','name'=>'/common/menu/*','title'=>'菜单列表','app_id'=>'backend','addons_name'=>'','pid'=>'13','level'=>'4','is_addon'=>'0','sort'=>'0','tree'=>'tr_0 tr_38 tr_41 tr_61 ','status'=>'1','created_at'=>'1582376901','updated_at'=>'1616338155']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'15','name'=>'/common/menu-cate/*','title'=>'菜单分类','app_id'=>'backend','addons_name'=>'','pid'=>'13','level'=>'4','is_addon'=>'0','sort'=>'1','tree'=>'tr_0 tr_38 tr_41 tr_61 ','status'=>'1','created_at'=>'1582376901','updated_at'=>'1616338203']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'16','name'=>'backendMemberAuth','title'=>'用户权限','app_id'=>'backend','addons_name'=>'','pid'=>'5','level'=>'2','is_addon'=>'0','sort'=>'3','tree'=>'tr_0 tr_38 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1616341730']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'17','name'=>'backendMember','title'=>'用户管理','app_id'=>'backend','addons_name'=>'','pid'=>'16','level'=>'3','is_addon'=>'0','sort'=>'0','tree'=>'tr_0 tr_38 tr_79 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1582376903']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'18','name'=>'baseAuthItem','title'=>'权限管理','app_id'=>'backend','addons_name'=>'','pid'=>'16','level'=>'3','is_addon'=>'0','sort'=>'1','tree'=>'tr_0 tr_38 tr_79 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1582376903']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'19','name'=>'basenAuthRole','title'=>'角色管理','app_id'=>'backend','addons_name'=>'','pid'=>'16','level'=>'3','is_addon'=>'0','sort'=>'2','tree'=>'tr_0 tr_38 tr_79 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1582376903']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'20','name'=>'/base/member/index','title'=>'列表','app_id'=>'backend','addons_name'=>'','pid'=>'17','level'=>'4','is_addon'=>'0','sort'=>'0','tree'=>'tr_0 tr_38 tr_79 tr_80 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1616338421']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'21','name'=>'/base/member/ajax-edit','title'=>'创建','app_id'=>'backend','addons_name'=>'','pid'=>'17','level'=>'4','is_addon'=>'0','sort'=>'1','tree'=>'tr_0 tr_38 tr_79 tr_80 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1582376903']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'22','name'=>'/base/member/destroy','title'=>'删除','app_id'=>'backend','addons_name'=>'','pid'=>'17','level'=>'4','is_addon'=>'0','sort'=>'2','tree'=>'tr_0 tr_38 tr_79 tr_80 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1616338434']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'23','name'=>'/base/member/edit','title'=>'编辑','app_id'=>'backend','addons_name'=>'','pid'=>'17','level'=>'4','is_addon'=>'0','sort'=>'4','tree'=>'tr_0 tr_38 tr_79 tr_80 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1616338460']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'24','name'=>'/base/member/ajax-update','title'=>'禁用','app_id'=>'backend','addons_name'=>'','pid'=>'17','level'=>'4','is_addon'=>'0','sort'=>'3','tree'=>'tr_0 tr_38 tr_79 tr_80 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1616338445']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'25','name'=>'/base/auth-item/index','title'=>'列表','app_id'=>'backend','addons_name'=>'','pid'=>'18','level'=>'4','is_addon'=>'0','sort'=>'0','tree'=>'tr_0 tr_38 tr_79 tr_86 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1616338641']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'26','name'=>'/base/auth-item/ajax-edit','title'=>'创建','app_id'=>'backend','addons_name'=>'','pid'=>'18','level'=>'4','is_addon'=>'0','sort'=>'1','tree'=>'tr_0 tr_38 tr_79 tr_86 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1582376903']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'27','name'=>'/base/auth-item/delete','title'=>'删除','app_id'=>'backend','addons_name'=>'','pid'=>'18','level'=>'4','is_addon'=>'0','sort'=>'2','tree'=>'tr_0 tr_38 tr_79 tr_86 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1616338656']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'28','name'=>'/base/auth-item/ajax-update','title'=>'禁用','app_id'=>'backend','addons_name'=>'','pid'=>'18','level'=>'4','is_addon'=>'0','sort'=>'3','tree'=>'tr_0 tr_38 tr_79 tr_86 ','status'=>'1','created_at'=>'1582376903','updated_at'=>'1616338671']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'29','name'=>'/base/auth-role/index','title'=>'列表','app_id'=>'backend','addons_name'=>'','pid'=>'19','level'=>'4','is_addon'=>'0','sort'=>'0','tree'=>'tr_0 tr_38 tr_79 tr_91 ','status'=>'1','created_at'=>'1582376904','updated_at'=>'1616338713']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'30','name'=>'/base/auth-role/edit','title'=>'创建','app_id'=>'backend','addons_name'=>'','pid'=>'19','level'=>'4','is_addon'=>'0','sort'=>'1','tree'=>'tr_0 tr_38 tr_79 tr_91 ','status'=>'1','created_at'=>'1582376904','updated_at'=>'1582376904']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'31','name'=>'/base/auth-role/delete','title'=>'删除','app_id'=>'backend','addons_name'=>'','pid'=>'19','level'=>'4','is_addon'=>'0','sort'=>'2','tree'=>'tr_0 tr_38 tr_79 tr_91 ','status'=>'1','created_at'=>'1582376904','updated_at'=>'1616338724']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'32','name'=>'/base/auth-role/ajax-update','title'=>'禁用','app_id'=>'backend','addons_name'=>'','pid'=>'19','level'=>'4','is_addon'=>'0','sort'=>'3','tree'=>'tr_0 tr_38 tr_79 tr_91 ','status'=>'1','created_at'=>'1582376904','updated_at'=>'1616338741']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'33','name'=>'/common/system/info','title'=>'系统信息','app_id'=>'backend','addons_name'=>'','pid'=>'5','level'=>'2','is_addon'=>'0','sort'=>'4','tree'=>'tr_0 tr_38 ','status'=>'1','created_at'=>'1582376904','updated_at'=>'1616341732']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'34','name'=>'cate:2','title'=>'应用中心','app_id'=>'backend','addons_name'=>'','pid'=>'0','level'=>'1','is_addon'=>'0','sort'=>'5','tree'=>'tr_0 ','status'=>'1','created_at'=>'1582376906','updated_at'=>'1616341737']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'35','name'=>'base','title'=>'系统基础','app_id'=>'merchant','addons_name'=>'','pid'=>'0','level'=>'1','is_addon'=>'0','sort'=>'0','tree'=>'tr_0 ','status'=>'1','created_at'=>'1582376927','updated_at'=>'1582376927']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'36','name'=>'/base/member/personal','title'=>'个人信息','app_id'=>'merchant','addons_name'=>'','pid'=>'35','level'=>'2','is_addon'=>'0','sort'=>'1','tree'=>'tr_0 tr_126 ','status'=>'1','created_at'=>'1582376927','updated_at'=>'1613934939']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'37','name'=>'/base/member/up-password','title'=>'修改密码','app_id'=>'merchant','addons_name'=>'','pid'=>'35','level'=>'2','is_addon'=>'0','sort'=>'2','tree'=>'tr_0 tr_126 ','status'=>'1','created_at'=>'1582376927','updated_at'=>'1613934940']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'38','name'=>'cate:3','title'=>'应用中心','app_id'=>'merchant','addons_name'=>'','pid'=>'0','level'=>'1','is_addon'=>'0','sort'=>'3','tree'=>'tr_0 ','status'=>'1','created_at'=>'1582376930','updated_at'=>'1582376930']);
        $this->insert('{{%rbac_auth_item}}',['id'=>'40','name'=>'/migrate/*','title'=>'所有权限','app_id'=>'backend','addons_name'=>'Migrate','pid'=>'0','level'=>'1','is_addon'=>'1','sort'=>'9999','tree'=>'tr_0 ','status'=>'1','created_at'=>'1629180628','updated_at'=>'1629180628']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%rbac_auth_item}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

