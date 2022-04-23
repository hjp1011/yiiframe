<?php

use yii\db\Migration;

class m210817_163345_common_config_cate extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%common_config_cate}}', [
            'id' => "int(10) NOT NULL AUTO_INCREMENT COMMENT '主键'",
            'title' => "varchar(50) NOT NULL DEFAULT '' COMMENT '标题'",
            'pid' => "int(10) unsigned NULL DEFAULT '0' COMMENT '上级id'",
            'app_id' => "varchar(20) NOT NULL DEFAULT '' COMMENT '应用'",
            'level' => "tinyint(1) unsigned NULL DEFAULT '1' COMMENT '级别'",
            'sort' => "int(5) NULL DEFAULT '0' COMMENT '排序'",
            'tree' => "varchar(300) NOT NULL DEFAULT '' COMMENT '树'",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态[-1:删除;0:禁用;1启用]'",
            'created_at' => "int(10) unsigned NULL DEFAULT '0' COMMENT '添加时间'",
            'updated_at' => "int(10) unsigned NULL DEFAULT '0' COMMENT '修改时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='系统_配置分类表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%common_config_cate}}',['id'=>'1','title'=>'站点配置','pid'=>'0','app_id'=>'backend','level'=>'1','sort'=>'0','tree'=>'tr_0 ','status'=>'1','created_at'=>'1553908350','updated_at'=>'1629090244']);
        $this->insert('{{%common_config_cate}}',['id'=>'2','title'=>'系统配置','pid'=>'0','app_id'=>'backend','level'=>'1','sort'=>'1','tree'=>'tr_0 ','status'=>'1','created_at'=>'1553908371','updated_at'=>'1553908509']);
        $this->insert('{{%common_config_cate}}',['id'=>'3','title'=>'基本配置','pid'=>'1','app_id'=>'backend','level'=>'2','sort'=>'0','tree'=>'tr_0 tr_1 ','status'=>'1','created_at'=>'1553908574','updated_at'=>'1629090379']);
        $this->insert('{{%common_config_cate}}',['id'=>'4','title'=>'系统基础','pid'=>'2','app_id'=>'backend','level'=>'2','sort'=>'0','tree'=>'tr_0 tr_2 ','status'=>'1','created_at'=>'1553908618','updated_at'=>'1553908618']);
        $this->insert('{{%common_config_cate}}',['id'=>'5','title'=>'图片处理','pid'=>'2','app_id'=>'backend','level'=>'2','sort'=>'1','tree'=>'tr_0 tr_2 ','status'=>'1','created_at'=>'1553908747','updated_at'=>'1553908747']);
        $this->insert('{{%common_config_cate}}',['id'=>'6','title'=>'系统配置','pid'=>'0','app_id'=>'merchant','level'=>'1','sort'=>'0','tree'=>'tr_0 ','status'=>'1','created_at'=>'1572587852','updated_at'=>'1572587852']);
        $this->insert('{{%common_config_cate}}',['id'=>'7','title'=>'系统基础','pid'=>'6','app_id'=>'merchant','level'=>'2','sort'=>'0','tree'=>'tr_0 tr_36 ','status'=>'1','created_at'=>'1572587861','updated_at'=>'1572587861']);
        $this->insert('{{%common_config_cate}}',['id'=>'8','title'=>'关于我们','pid'=>'0','app_id'=>'backend','level'=>'1','sort'=>'3','tree'=>'tr_0 ','status'=>'1','created_at'=>'1617627268','updated_at'=>'1617627284']);
        $this->insert('{{%common_config_cate}}',['id'=>'9','title'=>'注册协议','pid'=>'0','app_id'=>'backend','level'=>'1','sort'=>'4','tree'=>'tr_0 ','status'=>'1','created_at'=>'1617627317','updated_at'=>'1617627330']);
        $this->insert('{{%common_config_cate}}',['id'=>'10','title'=>'隐私协议','pid'=>'0','app_id'=>'backend','level'=>'1','sort'=>'5','tree'=>'tr_0 ','status'=>'1','created_at'=>'1617627325','updated_at'=>'1617627331']);
        $this->insert('{{%common_config_cate}}',['id'=>'11','title'=>'关于我们','pid'=>'8','app_id'=>'backend','level'=>'2','sort'=>'0','tree'=>'tr_0 tr_8 ','status'=>'1','created_at'=>'1617627440','updated_at'=>'1617627440']);
        $this->insert('{{%common_config_cate}}',['id'=>'12','title'=>'注册协议','pid'=>'9','app_id'=>'backend','level'=>'2','sort'=>'0','tree'=>'tr_0 tr_9 ','status'=>'1','created_at'=>'1617627456','updated_at'=>'1617627456']);
        $this->insert('{{%common_config_cate}}',['id'=>'13','title'=>'隐私协议','pid'=>'10','app_id'=>'backend','level'=>'2','sort'=>'0','tree'=>'tr_0 tr_10 ','status'=>'1','created_at'=>'1617627461','updated_at'=>'1617627461']);
        $this->insert('{{%common_config_cate}}',['id'=>'14','title'=>'关于我们','pid'=>'0','app_id'=>'merchant','level'=>'1','sort'=>'3','tree'=>'tr_0 ','status'=>'1','created_at'=>'1617627268','updated_at'=>'1617627284']);
        $this->insert('{{%common_config_cate}}',['id'=>'15','title'=>'关于我们','pid'=>'14','app_id'=>'merchant','level'=>'2','sort'=>'0','tree'=>'tr_0 tr_14  ','status'=>'1','created_at'=>'1617627317','updated_at'=>'1617627330']);
        $this->insert('{{%common_config_cate}}',['id'=>'16','title'=>'注册协议','pid'=>'0','app_id'=>'merchant','level'=>'1','sort'=>'0','tree'=>'tr_0 ','status'=>'1','created_at'=>'1617627325','updated_at'=>'1617627331']);
        $this->insert('{{%common_config_cate}}',['id'=>'17','title'=>'注册协议','pid'=>'16','app_id'=>'merchant','level'=>'2','sort'=>'0','tree'=>'tr_0 tr_16  ','status'=>'1','created_at'=>'1617627440','updated_at'=>'1617627440']);
        $this->insert('{{%common_config_cate}}',['id'=>'18','title'=>'隐私协议','pid'=>'0','app_id'=>'merchant','level'=>'1','sort'=>'0','tree'=>'tr_0 ','status'=>'1','created_at'=>'1617627456','updated_at'=>'1617627456']);
        $this->insert('{{%common_config_cate}}',['id'=>'19','title'=>'隐私协议','pid'=>'18','app_id'=>'merchant','level'=>'2','sort'=>'0','tree'=>'tr_0 tr_18  ','status'=>'1','created_at'=>'1617627461','updated_at'=>'1617627461']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%common_config_cate}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

