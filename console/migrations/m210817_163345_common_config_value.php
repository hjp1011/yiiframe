<?php

use yii\db\Migration;

class m210817_163345_common_config_value extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%common_config_value}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键'",
            'merchant_id' => "int(10) unsigned NULL DEFAULT '0' COMMENT '商户id'",
            'app_id' => "varchar(20) NOT NULL DEFAULT '' COMMENT '应用'",
            'config_id' => "int(10) NOT NULL DEFAULT '0' COMMENT '配置id'",
            'data' => "text NULL COMMENT '配置内'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='系统_配置值表'");
        
        /* 索引设置 */
        $this->createIndex('config_id','{{%common_config_value}}','config_id',0);
        
        
        /* 表数据 */
        $this->insert('{{%common_config_value}}',['id'=>'1','merchant_id'=>'0','app_id'=>'backend','config_id'=>'7','data'=>'']);
        $this->insert('{{%common_config_value}}',['id'=>'2','merchant_id'=>'0','app_id'=>'backend','config_id'=>'8','data'=>'1']);
        $this->insert('{{%common_config_value}}',['id'=>'3','merchant_id'=>'0','app_id'=>'backend','config_id'=>'9','data'=>'0']);
        $this->insert('{{%common_config_value}}',['id'=>'4','merchant_id'=>'0','app_id'=>'backend','config_id'=>'11','data'=>'1']);
        $this->insert('{{%common_config_value}}',['id'=>'5','merchant_id'=>'0','app_id'=>'backend','config_id'=>'14','data'=>'1']);
        $this->insert('{{%common_config_value}}',['id'=>'6','merchant_id'=>'0','app_id'=>'backend','config_id'=>'15','data'=>'1']);
        $this->insert('{{%common_config_value}}',['id'=>'7','merchant_id'=>'0','app_id'=>'backend','config_id'=>'32','data'=>'zh-CN']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%common_config_value}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

