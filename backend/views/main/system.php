<?php

use common\helpers\Url;
$this->title = Yii::t('app','指示板');
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<style>
    .info-box-number {
        font-size: 20px;
    }

    .info-box-content {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<div class="row">

    <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
            <div class="info-box-content p-md">
                <span class="info-box-number"><i class="icon ion-person-stalker "></i> <?= $member ?? 0 ?></span>
                <span class="info-box-text"><?=Yii::t('app','用户数');?></span>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
            <div class="info-box-content p-md">
                <span class="info-box-number"><i
                            class="icon glyphicon glyphicon-eye-open  red"></i> <?= $behavior ?? 0 ?></span>
                <span class="info-box-text"><?=Yii::t('app','行为监控');?></span>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
            <div class="info-box-content p-md">
                <span class="info-box-number"><i class="icon glyphicon glyphicon-globe cyan"></i> <?= $logCount ?? 0 ?></span>
                <span class="info-box-text"><?=Yii::t('app','全局日志');?></span>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
            <div class="info-box-content p-md">
                <span class="info-box-number"><i
                            class="icon glyphicon glyphicon-briefcase blue"></i> <?= $attachment ?? 0 ?></span>
                <span class="info-box-text"><?=Yii::t('app','资源文件');?></span>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
            <div class="info-box-content p-md">
                <span class="info-box-number"><i
                            class="icon glyphicon glyphicon-save-file  green"></i> <?= $attachmentSize ?? 0 ?>MiB</span>
                <span class="info-box-text"><?=Yii::t('app','附件大小');?></span>
            </div>
        </div>
    </div>

    <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
            <div class="info-box-content p-md">
                <span class="info-box-number"><i
                            class="icon glyphicon glyphicon-tasks "></i> <?= $mysql_size ?? 0 ?></span>
                <span class="info-box-text"><?=Yii::t('app','数据库大小');?></span>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6 col-xs-6">
        <div class="box box-solid">
            <div class="box-header">
                <i class="fa fa-circle blue" style="font-size: 8px"></i>
                <h3 class="box-title"><?=Yii::t('app','登陆统计');?></h3>
            </div>
            <?= \common\widgets\echarts\Echarts::widget([
                'config' => [
                    'server' => Url::to(['login-count']),
                    'height' => '280px'
                ],
                'theme' => 'area-stack',
                'themeJs' => 'wonderland'
            ]) ?>
        </div>
    </div>
    <div class="col-md-3 col-xs-3">
        <div class="box box-solid">
            <div class="box-header">
                <i class="fa fa-circle blue" style="font-size: 8px"></i>
                <h3 class="box-title"><?=Yii::t('app','日志分布');?></h3>
            </div>
            <?= \common\widgets\echarts\Echarts::widget([
                'config' => [
                    'server' => Url::to(['log-count']),
                    'height' => '280px',
                ],
                'theme' => 'wordcloud',
                'themeJs' => 'westeros',
                'themeConfig' => [
                        'all' => '全部',
                 ],
                
            ]) ?>
        </div>
    </div>
    <div class="col-md-3 col-xs-3">
        <div class="box box-solid">
            <div class="box-header">
                <i class="fa fa-circle blue" style="font-size: 8px"></i>
                <h3 class="box-title"><?=Yii::t('app','会员统计');?></h3>
            </div>
            <?= \common\widgets\echarts\Echarts::widget([
                'config' => [
                    'server' => Url::to(['member-count']),
                    'height' => '280px'
                ],
                'theme' => 'pie',
                // 'themeJs' => 'wonderland',
                'themeConfig' => [
                        'all' => '全部',
                 ],
            ]) ?>
        </div>
    </div>
    
</div>
<div class="row">
    
</div>