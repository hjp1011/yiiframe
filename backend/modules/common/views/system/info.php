<?php
use common\helpers\RegularHelper;
use common\helpers\Html;

$this->title = Yii::t('app','系统信息');
$this->params['breadcrumbs'][] = ['label' =>  $this->title];

$prefix = !RegularHelper::verify('url', Yii::getAlias('@attachurl')) ? Yii::$app->request->hostInfo : '';
?>

<div class="row">
    <div class="col-xs-7">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-cog"></i> <?=Yii::t('app','配置列表')?></h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <tr >
                        <td style="width: 100px">PHP</td>
                        <td><?= phpversion(); ?></td>
                    </tr>
                    <tr>
                        <td>Mysql</td>
                        <td><?= Yii::$app->db->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION); ?></td>
                    </tr>
                    <tr>
                        <td>Parsing engine</td>
                        <td><?= $_SERVER['SERVER_SOFTWARE']; ?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','数据库大小')?></td>
                        <td><?= Yii::$app->formatter->asShortSize($mysql_size, 2); ?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','附件')?></td>
                        <td><?= Yii::getAlias('@attachment'); ?>/</td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','附件大小')?></td>
                        <td><?= Yii::$app->formatter->asShortSize($attachment_size, 2); ?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','超时时间')?></td>
                        <td><?= ini_get('max_execution_time'); ?>秒</td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','客户端')?></td>
                        <td><?= $_SERVER['HTTP_USER_AGENT'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-5">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-code"></i> <?=Yii::t('app','系统信息')?></h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <tr>
                        <td style="width: 100px"><?=Yii::t('app','系统名称')?></td>
                        <td><?= Yii::$app->params['exploitFullName']; ?> </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?=Yii::t('app','PHP快速开发框架，为二次开发而生')?></td>
                    </tr>

                    <tr>
                        <td><?=Yii::t('app','Yii2版本')?></td>
                        <td><?= Yii::getVersion(); ?><?php if (YII_DEBUG) echo '('.Yii::t('app','开发模式').')'; ?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','官网')?></td>
                        <td><?= Yii::$app->params['exploitOfficialWebsite']?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','QQ')?></td>
                        <td>
                            <a href="#" target="_blank">21931118</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Git</td>
                        <td><?= Yii::$app->params['exploitGitHub']?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','开发者')?></td>
                        <td><?= Yii::$app->params['exploitDeveloper']?></td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','版本')?></td>
                        <td><?= Yii::$app->debris->version()['version'].'('.Yii::$app->debris->version()['updatetime'].')'; ?> </td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','授权')?></td>
                        <td><?= $domain_time ?> </td>
                    </tr>
                    <tr>
                        <td><?=Yii::t('app','版本检测')?></td>
                        <td><?= $updateinfo; ?></td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>

</div>