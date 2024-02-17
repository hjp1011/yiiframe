<?php

use yii\widgets\ActiveForm;
use common\helpers\Url;
use common\enums\GenderEnum;
use common\helpers\Html;
use yiiframe\plugs\common\AddonHelper;

?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-sm-3">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black"
                 style="background: url('<?= Yii::getAlias('@web'); ?>/resources/img/photo1.jpg') center center;">
                <h3 class="widget-user-username"><?= $model->username; ?></h3>
                <h5 class="widget-user-desc"><?=Yii::t('app', '最后登录时间')?>：<?= Yii::$app->formatter->asDatetime($model->last_time) ?></h5>
                <h5><?=Yii::t('app', '最后登录IP')?>：<?= $model->last_ip ?></h5>
            </div>
            <?php if (AddonHelper::isInstall('Monitoring')) {
                    $actionLog = Yii::$app->monitoringService->log->findByAppId(Yii::$app->id, $model['id'], 10);
                ?>
                <div class="box-body">
                    <div class="col-md-12 changelog-info">
                        <ul class="time-line">
                            <?php foreach ($actionLog as $item) { ?>
                                <li>
                                    <time><?= Yii::$app->formatter->asDatetime($item['created_at']) ?></time>
                                    <h5><?= $item['remark'] ?></h5>
                                </li>
                            <?php } ?>
                        </ul>
                        <!-- /.widget-user -->
                    </div>
                    <div class="pull-right">
                        <a href="<?= Url::to(['/monitoring/log/index']); ?>" class="openContab blue" data-title="行为日志"><?=Yii::t('app', '更多')?></a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="box-body">
                    <div class="col-md-12 changelog-info">
                        <?=Yii::t('app', '暂无行为记录...')?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#base" data-toggle="tab" aria-expanded="true"><?=Yii::t('app', '个人信息')?></a></li>
                
            </ul>
            <div class="tab-content">
                <div class="active tab-pane active" id="base">
                    <div class="col-lg-12">
                        <?php
                        if(AddonHelper::isInstall('Webuploader')&&AddonHelper::isInstall('Cropper'))
                        echo $form->field($model, 'head_portrait')->widget(\addons\Cropper\common\widgets\cropper\Cropper::class, []);
                        ?>
                        <?= $form->field($model, 'realname')->textInput() ?>
                        <?= $form->field($model, 'gender')->radioList(GenderEnum::getMap()) ?>
                        <?= $form->field($model, 'mobile')->textInput() ?>
                        <?php
                            if (AddonHelper::isInstall('Provinces'))
                            echo \addons\Provinces\common\widgets\provinces\Provinces::widget([
                                'form' => $form,
                                'model' => $model,
                                'provincesName' => 'province_id',// 省字段名
                                'cityName' => 'city_id',// 市字段名
                                'areaName' => 'area_id',// 区字段名
                                'template' => 'short' //合并为一行显示
                            ]); ?>
                        <?= $form->field($model, 'email')->textInput() ?>
                        <?= $form->field($model, 'birthday')->widget('kartik\date\DatePicker', [
                            'language' => 'zh-CN',
                            'layout' => '{picker}{input}',
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,// 今日高亮
                                'autoclose' => true,// 选择后自动关闭
                                'todayBtn' => true,// 今日按钮显示
                            ],
                            'options' => [
                                'class' => 'form-control no_bor',
                            ]
                        ]); ?>
                        <?= $form->field($model, 'address')->textarea() ?>
                        <?= $form->field($model, 'status')->radioList(\common\enums\StatusEnum::getMap()) ?>
                    </div>
                </div>
              

                <div class="box-footer text-center">
                    <button class="btn btn-primary" type="submit" onclick="sendForm()"><?=Yii::t('app', '保存')?></button>
                    <?= $backBtn ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script type="text/javascript">
    // 提交表单时候触发
    function sendForm() {
        var status = "<?= Yii::$app->user->id == $model->id ? true : false;?>";
        if (status) {
            var src = $('input[name="Manager[head_portrait]"]').val();
            if (src) {
                $('.head_portrait', window.parent.document).attr('src', src);
            }
        }
    }
</script>