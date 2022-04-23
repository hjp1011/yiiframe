<?php
use common\helpers\ImageHelper;
use common\widgets\menu\MenuLeftWidget;
?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img class="img-circle head_portrait" src="<?= ImageHelper::defaultHeaderPortrait($manager->head_portrait); ?>"/>
            </div>
            <div class="pull-left info">
                <p><?= $manager->username; ?></p>
                <a href="#">
                    <i class="fa fa-circle text-success"></i>
                    <?php if (Yii::$app->services->auth->isSuperAdmin()){ ?>
                        <?=Yii::t('app','超级管理员');?>
                    <?php }else{ ?>
                        <?= Yii::$app->services->rbacAuthRole->getTitle() ?>
                    <?php } ?>
                </a>
            </div>
        </div>
        <!-- 侧边菜单 -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header" data-rel="external"><?=Yii::t('app','系统菜单');?></li>
            <?= MenuLeftWidget::widget(); ?>
            <?php if (Yii::$app->debris->backendConfig('sys_related_links') == true){ ?>
                <li class="header" data-rel="external"><?=Yii::t('app','相关链接');?></li>
                <li><a href="http://www.yiiframe.com" target="_blank"><i class="fa fa-bookmark text-red"></i> <span><?=Yii::t('app','官网');?></span></a></li>
                <li><a href="http://doc.yiiframe.com" target="_blank"><i class="fa fa-list text-yellow"></i> <span><?=Yii::t('app','文档');?></span></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-qq text-aqua"></i> <span>QQ群1107210028</span></a></li>
            <?php } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
