<?php

use common\helpers\RegularHelper;

$this->title = '系统信息';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];

$prefix = !RegularHelper::verify('url', Yii::getAlias('@attachurl')) ? Yii::$app->request->hostInfo : '';
?>

<div class="row">
    <div class="col-xs-7">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-cog"></i> 环境配置</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <tr >
                        <td style="width: 100px">PHP版本</td>
                        <td><?= phpversion(); ?></td>
                    </tr>
                    <tr>
                        <td>Mysql版本</td>
                        <td><?= Yii::$app->db->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION); ?></td>
                    </tr>
                    <tr>
                        <td>解析引擎</td>
                        <td><?= $_SERVER['SERVER_SOFTWARE']; ?></td>
                    </tr>
                    <tr>
                        <td>数据库大小</td>
                        <td><?= Yii::$app->formatter->asShortSize($mysql_size, 2); ?></td>
                    </tr>
                    <tr>
                        <td>附件目录</td>
                        <td><?= Yii::getAlias('@attachment'); ?>/</td>
                    </tr>
                    <tr>
                        <td>附件目录大小</td>
                        <td><?= Yii::$app->formatter->asShortSize($attachment_size, 2); ?></td>
                    </tr>
                    <tr>
                        <td>超时时间</td>
                        <td><?= ini_get('max_execution_time'); ?>秒</td>
                    </tr>
                    <tr>
                        <td>客户端信息</td>
                        <td><?= $_SERVER['HTTP_USER_AGENT'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-5">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-code"></i> 系统信息</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <tr>
                        <td style="width: 100px">系统全称</td>
                        <td><?= Yii::$app->params['exploitFullName']; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>重量级PHP框架，为二次开发而生。</td>
                    </tr>

                    <tr>
                        <td>Yii2版本</td>
                        <td><?= Yii::getVersion(); ?><?php if (YII_DEBUG) echo ' (开发模式)'; ?></td>
                    </tr>
                    <tr>
                        <td>官网</td>
                        <td><?= Yii::$app->params['exploitOfficialWebsite']?></td>
                    </tr>
                    <tr>
                        <td>官方QQ群</td>
                        <td>
                            <a href="#" target="_blank">1107210028</a>
                        </td>
                    </tr>
                    <tr>
                        <td>GitHub</td>
                        <td><?= Yii::$app->params['exploitGitHub']?></td>
                    </tr>
                    <tr>
                        <td>开发者</td>
                        <td><?= Yii::$app->params['exploitDeveloper']?></td>
                    </tr>
                    <tr>
                        <td>系统授权</td>
                        <td><?= $domain_time ?> </td>
                    </tr>
                    <tr>
                        <td>当前版本</td>
                        <td><?= Yii::$app->debris->version()['version'].'('.Yii::$app->debris->version()['updatetime'].')'; ?> </td>
                    </tr>
                    <tr>
                        <td>版本检测</td>
                        <td><?= $updateinfo; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>