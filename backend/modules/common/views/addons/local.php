<?php

use common\helpers\Url;
use common\helpers\Html;
use yiiframe\addonhelper\AddonHelper;

$this->title = Yii::t('merchant', '未安装');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="row">
    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li><a href="<?= Url::to(['index']) ?>"><?=Yii::t('merchant', '已安装')?></a></li>
                <li class="active"><a href="<?= Url::to(['local']) ?>"><?=Yii::t('merchant', '未安装')?></a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th><?=Yii::t('merchant', '图标')?></th>
                            <th><?=Yii::t('merchant', '插件名称')?></th>
                            <th><?=Yii::t('merchant', '作者')?></th>
                            <th><?=Yii::t('merchant', '简介')?></th>
                            <th><?=Yii::t('merchant', '版本')?></th>
                            <th><?=Yii::t('merchant', '操作')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list as $key => $vo) { ?>
                            <tr>
                                <td class="feed-element" style="width: 70px">
                                    <img alt="image" class="img-rounded m-t-xs img-responsive" src="<?= AddonHelper::getAddonIcon($vo['name']); ?>" width="64" height="64">
                                </td>
                                <td>
                                    <h5><?= Html::encode($vo['title']) ?></h5>
                                    <small><?= Html::encode($vo['name']) ?></small>
                                </td>
                                <td><?= Html::encode($vo['author']) ?></td>
                                <td><?= Html::encode($vo['brief_introduction']) ?></td>
                                <td><?= Html::encode($vo['version']) ?></td>
                                <td>
                                    <a href="<?= Url::to(['install', 'name' => $vo['name'],'title'=>$vo['title']]) ?>"><span class="btn btn-primary btn-sm"><?=Yii::t('merchant', '安装')?></span></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
