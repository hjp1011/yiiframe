<?php

use yii\db\Migration;

class m210817_163345_common_menu extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%common_menu}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'title' => "varchar(50) NOT NULL DEFAULT '' COMMENT '标题'",
            'app_id' => "varchar(20) NOT NULL DEFAULT '' COMMENT '应用'",
            'addons_name' => "varchar(100) NOT NULL DEFAULT '' COMMENT '插件名称'",
            'is_addon' => "tinyint(1) unsigned NULL DEFAULT '0' COMMENT '是否插件'",
            'cate_id' => "int(10) unsigned NULL DEFAULT '0' COMMENT '分类id'",
            'pid' => "int(50) unsigned NULL DEFAULT '0' COMMENT '上级id'",
            'url' => "varchar(100) NULL DEFAULT '' COMMENT '路由'",
            'icon' => "varchar(50) NULL DEFAULT '' COMMENT '样式'",
            'level' => "tinyint(1) unsigned NULL DEFAULT '1' COMMENT '级别'",
            'dev' => "tinyint(4) unsigned NULL DEFAULT '0' COMMENT '开发者[0:都可见;开发模式可见]'",
            'sort' => "int(5) NULL DEFAULT '999' COMMENT '排序'",
            'params' => "json NULL COMMENT '参数'",
            'tree' => "varchar(300) NOT NULL DEFAULT '' COMMENT '树'",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态[-1:删除;0:禁用;1启用]'",
            'created_at' => "int(10) unsigned NULL DEFAULT '0' COMMENT '添加时间'",
            'updated_at' => "int(10) unsigned NULL DEFAULT '0' COMMENT '修改时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='系统_菜单导航表'");
        
        /* 索引设置 */
        $this->createIndex('url','{{%common_menu}}','url',0);
        
        
        /* 表数据 */
        $this->insert('{{%common_menu}}',['id'=>'1','title'=>'站点设置','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'0','url'=>'/common/config/edit-all','icon'=>'fa-cog','level'=>'1','dev'=>'0','sort'=>'1','params'=>'"[]"','tree'=>'tr_0 ','status'=>'1','created_at'=>'1572328434','updated_at'=>'1572417529']);
        $this->insert('{{%common_menu}}',['id'=>'2','title'=>'用户权限','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'0','url'=>'backendMemberAuth','icon'=>'fa-user-secret','level'=>'1','dev'=>'0','sort'=>'4','params'=>'"[]"','tree'=>'tr_0 ','status'=>'1','created_at'=>'1572328496','updated_at'=>'1617449969']);
        $this->insert('{{%common_menu}}',['id'=>'3','title'=>'用户管理','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'2','url'=>'/base/member/index','icon'=>'','level'=>'2','dev'=>'0','sort'=>'1','params'=>'"[]"','tree'=>'tr_0 tr_2 ','status'=>'1','created_at'=>'1572328535','updated_at'=>'1572560511']);
        $this->insert('{{%common_menu}}',['id'=>'4','title'=>'角色管理','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'2','url'=>'/base/auth-role/index','icon'=>'','level'=>'2','dev'=>'0','sort'=>'2','params'=>'"[]"','tree'=>'tr_0 tr_2 ','status'=>'1','created_at'=>'1572329079','updated_at'=>'1582377757']);
        $this->insert('{{%common_menu}}',['id'=>'5','title'=>'权限管理','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'2','url'=>'/base/auth-item/index','icon'=>'','level'=>'2','dev'=>'1','sort'=>'3','params'=>'"[]"','tree'=>'tr_0 tr_2 ','status'=>'1','created_at'=>'1572329162','updated_at'=>'1582377769']);
        $this->insert('{{%common_menu}}',['id'=>'6','title'=>'系统功能','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'0','url'=>'commonFunction','icon'=>'fa-list-ul','level'=>'1','dev'=>'1','sort'=>'3','params'=>'"[]"','tree'=>'tr_0 ','status'=>'1','created_at'=>'1572329735','updated_at'=>'1617449968']);
        $this->insert('{{%common_menu}}',['id'=>'7','title'=>'系统信息','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'0','url'=>'/common/system/info','icon'=>'fa-microchip','level'=>'1','dev'=>'0','sort'=>'6','params'=>'"[]"','tree'=>'tr_0 ','status'=>'1','created_at'=>'1572329902','updated_at'=>'1616340118']);
        $this->insert('{{%common_menu}}',['id'=>'8','title'=>'应用管理','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'0','url'=>'/common/addons/index','icon'=>'fa-cubes','level'=>'2','dev'=>'0','sort'=>'5','params'=>'"[]"','tree'=>'tr_0 ','status'=>'1','created_at'=>'1572330081','updated_at'=>'1617449970']);
        $this->insert('{{%common_menu}}',['id'=>'9','title'=>'配置管理','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'6','url'=>'/common/config/index','icon'=>'','level'=>'2','dev'=>'1','sort'=>'2','params'=>'"[]"','tree'=>'tr_0 tr_6 ','status'=>'1','created_at'=>'1572330103','updated_at'=>'1572560457']);
        $this->insert('{{%common_menu}}',['id'=>'10','title'=>'菜单管理','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'6','url'=>'/common/menu/index','icon'=>'fa-puzzle-piec','level'=>'2','dev'=>'1','sort'=>'1','params'=>'"[]"','tree'=>'tr_0 tr_6 ','status'=>'1','created_at'=>'1572408688','updated_at'=>'1615908262']);
        $this->insert('{{%common_menu}}',['id'=>'11','title'=>'部门管理','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'0','url'=>'/base/department/index','icon'=>'fa-user-plus','level'=>'1','dev'=>'0','sort'=>'2','params'=>'"[]"','tree'=>'tr_0 ','status'=>'1','created_at'=>'1617449954','updated_at'=>'1617450104']);
        $this->insert('{{%common_menu}}',['id'=>'12','title'=>'代码生成','app_id'=>'backend','addons_name'=>'','is_addon'=>'0','cate_id'=>'1','pid'=>'0','url'=>'/gii','icon'=>'fa-code','level'=>'1','dev'=>'1','sort'=>'7','params'=>'"[]"','tree'=>'tr_0 ','status'=>'1','created_at'=>'1617449954','updated_at'=>'1617450104']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%common_menu}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

