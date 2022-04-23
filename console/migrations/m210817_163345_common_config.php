<?php

use yii\db\Migration;

class m210817_163345_common_config extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%common_config}}', [
            'id' => "int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键'",
            'title' => "varchar(50) NOT NULL DEFAULT '' COMMENT '配置标题'",
            'name' => "varchar(50) NOT NULL DEFAULT '' COMMENT '配置标识'",
            'app_id' => "varchar(20) NOT NULL DEFAULT '' COMMENT '应用'",
            'type' => "varchar(30) NOT NULL DEFAULT '' COMMENT '配置类型'",
            'cate_id' => "int(10) unsigned NOT NULL DEFAULT '0' COMMENT '配置分类'",
            'extra' => "varchar(1000) NOT NULL DEFAULT '' COMMENT '配置值'",
            'remark' => "varchar(1000) NOT NULL DEFAULT '' COMMENT '配置说明'",
            'is_hide_remark' => "tinyint(4) NULL DEFAULT '1' COMMENT '是否隐藏说明'",
            'default_value' => "varchar(500) NULL DEFAULT '' COMMENT '默认配置'",
            'sort' => "int(10) unsigned NULL DEFAULT '0' COMMENT '排序'",
            'status' => "tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态[-1:删除;0:禁用;1启用]'",
            'created_at' => "int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => "int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间'",
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='系统_配置表'");
        
        /* 索引设置 */
        $this->createIndex('type','{{%common_config}}','type',0);
        $this->createIndex('group','{{%common_config}}','cate_id',0);
        $this->createIndex('uk_name','{{%common_config}}','name',0);
        
        
        /* 表数据 */
        $this->insert('{{%common_config}}',['id'=>'1','title'=>'版权所有','name'=>'web_copyright','app_id'=>'backend','type'=>'text','cate_id'=>'3','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'4','status'=>'1','created_at'=>'1526199058','updated_at'=>'1613295211']);
        $this->insert('{{%common_config}}',['id'=>'2','title'=>'站点标题','name'=>'web_site_title','app_id'=>'backend','type'=>'text','cate_id'=>'3','extra'=>'','remark'=>'显示站点名称','is_hide_remark'=>'0','default_value'=>'','sort'=>'0','status'=>'1','created_at'=>'1526372845','updated_at'=>'1629091157']);
        $this->insert('{{%common_config}}',['id'=>'3','title'=>'站点logo','name'=>'web_logo','app_id'=>'backend','type'=>'image','cate_id'=>'3','extra'=>'','remark'=>'需要安装上传插件','is_hide_remark'=>'0','default_value'=>'','sort'=>'1','status'=>'1','created_at'=>'1526372885','updated_at'=>'1629091121']);
        $this->insert('{{%common_config}}',['id'=>'4','title'=>'备案号','name'=>'web_site_icp','app_id'=>'backend','type'=>'text','cate_id'=>'3','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'5','status'=>'1','created_at'=>'1526372926','updated_at'=>'1613295212']);
        $this->insert('{{%common_config}}',['id'=>'5','title'=>'站点统计代码','name'=>'web_visit_code','app_id'=>'backend','type'=>'textarea','cate_id'=>'3','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'7','status'=>'1','created_at'=>'1526373044','updated_at'=>'1629090014']);
        $this->insert('{{%common_config}}',['id'=>'6','title'=>'百度推送代码','name'=>'web_baidu_push','app_id'=>'backend','type'=>'textarea','cate_id'=>'3','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'6','status'=>'1','created_at'=>'1526373086','updated_at'=>'1629090003']);
        $this->insert('{{%common_config}}',['id'=>'7','title'=>'后台允许访问IP','name'=>'sys_allow_ip','app_id'=>'backend','type'=>'textarea','cate_id'=>'4','extra'=>'','remark'=>'多个用换行/逗号/分号分隔，如果不配置表示不限制IP访问','is_hide_remark'=>'0','default_value'=>'','sort'=>'4','status'=>'1','created_at'=>'1526374098','updated_at'=>'1629172060']);
        $this->insert('{{%common_config}}',['id'=>'8','title'=>'开发模式','name'=>'sys_dev','app_id'=>'backend','type'=>'radioList','cate_id'=>'4','extra'=>'1:开启,
0:关闭,','remark'=>'开启后某些菜单功能可见，修改后请刷新页面','is_hide_remark'=>'0','default_value'=>'0','sort'=>'0','status'=>'1','created_at'=>'1529117534','updated_at'=>'1554041531']);
        $this->insert('{{%common_config}}',['id'=>'9','title'=>'水印','name'=>'sys_image_watermark_status','app_id'=>'backend','type'=>'radioList','cate_id'=>'5','extra'=>'1:开启,
0:关闭,','remark'=>'','is_hide_remark'=>'1','default_value'=>'0','sort'=>'1','status'=>'1','created_at'=>'1537949984','updated_at'=>'1629090083']);
        $this->insert('{{%common_config}}',['id'=>'10','title'=>'图片','name'=>'sys_image_watermark_img','app_id'=>'backend','type'=>'image','cate_id'=>'5','extra'=>'','remark'=>'如果图片尺寸小于水印尺寸则水印不生效','is_hide_remark'=>'0','default_value'=>'','sort'=>'2','status'=>'1','created_at'=>'1537950064','updated_at'=>'1629090090']);
        $this->insert('{{%common_config}}',['id'=>'11','title'=>'位置','name'=>'sys_image_watermark_location','app_id'=>'backend','type'=>'radioList','cate_id'=>'5','extra'=>'1:左上,
2:中上,
3:右上,
4:左中,
5:正中,
6:右中,
7:左下,
8:中下,
9:右下,','remark'=>'','is_hide_remark'=>'1','default_value'=>'1','sort'=>'2','status'=>'1','created_at'=>'1537951491','updated_at'=>'1629214729']);
        $this->insert('{{%common_config}}',['id'=>'12','title'=>'SEO关键字','name'=>'web_seo_keywords','app_id'=>'backend','type'=>'text','cate_id'=>'3','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'2','status'=>'1','created_at'=>'1547087332','updated_at'=>'1572416677']);
        $this->insert('{{%common_config}}',['id'=>'13','title'=>'SEO内容','name'=>'web_seo_description','app_id'=>'backend','type'=>'textarea','cate_id'=>'3','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'3','status'=>'1','created_at'=>'1547087379','updated_at'=>'1572416677']);
        $this->insert('{{%common_config}}',['id'=>'14','title'=>'后台 Tab 页签','name'=>'sys_tags','app_id'=>'backend','type'=>'radioList','cate_id'=>'4','extra'=>'1:开启,
0:关闭,','remark'=>'修改后请刷新页面','is_hide_remark'=>'0','default_value'=>'1','sort'=>'1','status'=>'1','created_at'=>'1547778279','updated_at'=>'1554041532']);
        $this->insert('{{%common_config}}',['id'=>'15','title'=>'相关链接','name'=>'sys_related_links','app_id'=>'backend','type'=>'radioList','cate_id'=>'4','extra'=>'1:显示,
0:隐藏,','remark'=>'','is_hide_remark'=>'1','default_value'=>'0','sort'=>'3','status'=>'1','created_at'=>'1554041616','updated_at'=>'1629172059']);
        $this->insert('{{%common_config}}',['id'=>'16','title'=>'公司简介','name'=>'web_about_me','app_id'=>'backend','type'=>'baiduUEditor','cate_id'=>'11','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'9','status'=>'1','created_at'=>'1613295259','updated_at'=>'1617628309']);
        $this->insert('{{%common_config}}',['id'=>'17','title'=>'注册协议','name'=>'register_protocol','app_id'=>'backend','type'=>'baiduUEditor','cate_id'=>'12','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'0','status'=>'1','created_at'=>'1617627528','updated_at'=>'1617627528']);
        $this->insert('{{%common_config}}',['id'=>'18','title'=>'隐私协议','name'=>'privacy_protocol','app_id'=>'backend','type'=>'baiduUEditor','cate_id'=>'13','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'0','status'=>'1','created_at'=>'1617627558','updated_at'=>'1617627558']);
        $this->insert('{{%common_config}}',['id'=>'19','title'=>'联系方式','name'=>'web_contact','app_id'=>'backend','type'=>'text','cate_id'=>'11','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'0','status'=>'1','created_at'=>'1617628477','updated_at'=>'1617628477']);
        $this->insert('{{%common_config}}',['id'=>'20','title'=>'二维码','name'=>'web_qrcode','app_id'=>'backend','type'=>'image','cate_id'=>'11','extra'=>'','remark'=>'需要安装上传插件','is_hide_remark'=>'0','default_value'=>'','sort'=>'0','status'=>'1','created_at'=>'1617628552','updated_at'=>'1629120854']);
        $this->insert('{{%common_config}}',['id'=>'21','title'=>'后台 Tab 页签','name'=>'sys_tags','app_id'=>'merchant','type'=>'radioList','cate_id'=>'7','extra'=>'1:开启,
0:关闭,','remark'=>'修改后请刷新页面','is_hide_remark'=>'0','default_value'=>'1','sort'=>'1','status'=>'1','created_at'=>'1547778279','updated_at'=>'1554041532']);
        $this->insert('{{%common_config}}',['id'=>'22','title'=>'后台相关链接','name'=>'sys_related_links','app_id'=>'merchant','type'=>'radioList','cate_id'=>'7','extra'=>'1:显示,
0:隐藏,','remark'=>'','is_hide_remark'=>'1','default_value'=>'0','sort'=>'2','status'=>'1','created_at'=>'1554041616','updated_at'=>'1557213534']);
        $this->insert('{{%common_config}}',['id'=>'23','title'=>'联系方式','name'=>'web_contact','app_id'=>'merchant','type'=>'text','cate_id'=>'15','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'2','status'=>'1','created_at'=>'1617628477','updated_at'=>'1617628477']);
        $this->insert('{{%common_config}}',['id'=>'24','title'=>'二维码','name'=>'web_qrcode','app_id'=>'merchant','type'=>'image','cate_id'=>'15','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'6','status'=>'1','created_at'=>'1617628552','updated_at'=>'1617628552']);
        $this->insert('{{%common_config}}',['id'=>'25','title'=>'公司简介','name'=>'web_about_me','app_id'=>'merchant','type'=>'baiduUEditor','cate_id'=>'15','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'7','status'=>'1','created_at'=>'1613295259','updated_at'=>'1617628309']);
        $this->insert('{{%common_config}}',['id'=>'26','title'=>'QQ群','name'=>'web_qq','app_id'=>'merchant','type'=>'text','cate_id'=>'15','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'4','status'=>'1','created_at'=>'1617628477','updated_at'=>'1617628477']);
        $this->insert('{{%common_config}}',['id'=>'27','title'=>'企业LOGO','name'=>'web_logo','app_id'=>'merchant','type'=>'image','cate_id'=>'15','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'5','status'=>'1','created_at'=>'1617628552','updated_at'=>'1617628552']);
        $this->insert('{{%common_config}}',['id'=>'28','title'=>'企业名称','name'=>'web_site_title','app_id'=>'merchant','type'=>'text','cate_id'=>'15','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'1','status'=>'1','created_at'=>'1617628477','updated_at'=>'1617628477']);
        $this->insert('{{%common_config}}',['id'=>'29','title'=>'注册协议','name'=>'register_protocol','app_id'=>'merchant','type'=>'baiduUEditor','cate_id'=>'17','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'1','status'=>'1','created_at'=>'1617627528','updated_at'=>'1617627528']);
        $this->insert('{{%common_config}}',['id'=>'30','title'=>'隐私协议','name'=>'privacy_protocol','app_id'=>'merchant','type'=>'baiduUEditor','cate_id'=>'19','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'0','status'=>'1','created_at'=>'1617627558','updated_at'=>'1617627558']);
        $this->insert('{{%common_config}}',['id'=>'31','title'=>'联系地址','name'=>'web_address','app_id'=>'merchant','type'=>'text','cate_id'=>'15','extra'=>'','remark'=>'','is_hide_remark'=>'1','default_value'=>'','sort'=>'3','status'=>'1','created_at'=>'1617628477','updated_at'=>'1617628477']);
        $this->insert('{{%common_config}}',['id'=>'32','title'=>'语言','name'=>'language','app_id'=>'backend','type'=>'radioList','cate_id'=>'4','extra'=>'zh-CN:简体,zh-TW:繁体,en-US:英文,jp:日文','remark'=>'默认选择中文简体','is_hide_remark'=>'1','default_value'=>'zh-CN','sort'=>'2','status'=>'1','created_at'=>'1617628477','updated_at'=>'1629188361']);
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%common_config}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

