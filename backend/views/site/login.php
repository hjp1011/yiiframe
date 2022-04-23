<?php
$this->title = Yii::$app->params['adminTitle'];

use common\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
?>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <?= Html::encode(Yii::$app->debris->backendConfig('web_site_title', true)?Yii::$app->debris->backendConfig('web_site_title', true):Yii::$app->params['adminTitle']); ?>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?=Yii::t('app','欢迎登陆');?></p>
        <?php $form = ActiveForm::begin([
                'id' => 'login-form'
        ]); ?>
        <?= $form->field($model, 'username', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-user form-control-feedback"></span></div>{hint}{error}'
        ])->textInput(['placeholder' => Yii::t('app','用户名'),'value'=>''])->label(false); ?>
        <?= $form->field($model, 'password', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span></div>{hint}{error}'
        ])->passwordInput(['placeholder' => Yii::t('app','密码'),'value'=>''])->label(false); ?>
        <?php if ($model->scenario == 'captchaRequired') { ?>
            <?= $form->field($model,'verifyCode')->widget(Captcha::class,[
                'template' => '<div class="row"><div class="col-sm-7">{input}</div><div class="col-sm-5">{image}</div></div>',
                'imageOptions' => [
                    'alt' => Yii::t('app','点击换图'),
                    'title' => Yii::t('app','点击换图'),
                    'style' => 'cursor:pointer'
                ],
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app','验证码'),
                ],
            ])->label(false); ?>
        <?php } ?>
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','立即登录'), ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="social-auth-links text-center">
            <p><?= Html::encode(Yii::$app->debris->backendConfig('web_copyright')); ?></p>
        </div>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</body>

<script>
    //判断是否存在父窗口
    if (window.parent !== this.window ){
        parent.location.reload();
    }
</script>