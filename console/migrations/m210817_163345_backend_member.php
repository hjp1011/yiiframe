<?php

use yii\db\Migration;

class m210817_163345_backend_member extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%backend_member}}', [
            'id' => "int(11) NOT NULL AUTO_INCREMENT",
            'merchant_id' => "int(11) NULL DEFAULT '0' COMMENT '企业ID'",
            'department_id' => "int(11) NULL DEFAULT '0' COMMENT '机构ID'",
            'role_id' => "int(11) NULL DEFAULT '0' COMMENT '角色'",
            'username' => "varchar(20) NOT NULL DEFAULT '' COMMENT '帐号'",
            'password_hash' => "varchar(150) NOT NULL DEFAULT '' COMMENT '密码'",
            'auth_key' => "varchar(32) NOT NULL DEFAULT '' COMMENT '授权令牌'",
            'password_reset_token' => "varchar(150) NULL DEFAULT '' COMMENT '密码重置令牌'",
            'type' => "tinyint(1) NULL DEFAULT '1' COMMENT '1:普通管理员;10超级管理员'",
            'realname' => "varchar(10) NULL DEFAULT '' COMMENT '真实姓名'",
            'head_portrait' => "char(150) NULL DEFAULT '' COMMENT '头像'",
            'gender' => "tinyint(1) unsigned NULL DEFAULT '0' COMMENT '性别[0:未知;1:男;2:女]'",
            'qq' => "varchar(20) NULL DEFAULT '' COMMENT 'qq'",
            'email' => "varchar(60) NULL DEFAULT '' COMMENT '邮箱'",
            'birthday' => "date NULL COMMENT '生日'",
            'province_id' => "int(10) NULL DEFAULT '0' COMMENT '省'",
            'city_id' => "int(10) NULL DEFAULT '0' COMMENT '城市'",
            'area_id' => "int(10) NULL DEFAULT '0' COMMENT '地区'",
            'address' => "varchar(100) NULL DEFAULT '' COMMENT '默认地址'",
            'mobile' => "varchar(20) NULL DEFAULT '' COMMENT '手机号码'",
            'home_phone' => "varchar(20) NULL DEFAULT '' COMMENT '家庭号码'",
            'dingtalk_robot_token' => "varchar(100) NULL DEFAULT '' COMMENT '钉钉机器人token'",
            'visit_count' => "smallint(5) unsigned NULL DEFAULT '0' COMMENT '访问次数'",
            'last_time' => "int(10) NULL DEFAULT '0' COMMENT '最后一次登录时间'",
            'last_ip' => "varchar(16) NULL DEFAULT '' COMMENT '最后一次登录ip'",
            'role' => "smallint(6) NULL DEFAULT '10' COMMENT '权限'",
            'status' => "tinyint(4) NULL DEFAULT '1' COMMENT '状态[-1:删除;0:禁用;1启用]'",
            'created_at' => "int(10) unsigned NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => "int(10) unsigned NULL DEFAULT '0' COMMENT '修改时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='后台_用户表'");
        
        /* 索引设置 */
        
        
        /* 表数据 */
        $this->insert('{{%backend_member}}',['id'=>'1','merchant_id'=>'0','department_id'=>'0','role_id'=>'0','username'=>'admin','password_hash'=>'$2y$13$z4MYqzq3khd5V75KjQM6e.3hLB9/qVSdl1uWB5W9W4MbR4XJzELpi','auth_key'=>'z6lrwixmdNF4VqtkXw6z-3vMZdSdngm2','password_reset_token'=>'','type'=>'10','realname'=>'YiiFrame','head_portrait'=>'','gender'=>'1','qq'=>'','email'=>'','birthday'=>'2020-01-01','province_id'=>'230000','city_id'=>'230300','area_id'=>'230302','address'=>'','mobile'=>'18986860000','home_phone'=>'','dingtalk_robot_token'=>'','visit_count'=>'126','last_time'=>'1629213270','last_ip'=>'::1','role'=>'10','status'=>'1','created_at'=>'1449114934','updated_at'=>'1629213270']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%backend_member}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

