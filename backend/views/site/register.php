<?php

use common\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;

$this->title = '会员注册';
?>
<style type="text/css">
    .login-logo{
        color:#000000;
    }
</style>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="login-logo">
        <?= $this->title ?>
        
    </div>
    <div class="register-box-body">
        
        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
        ]); ?>
       
        
        <?= $form->field($model, 'realname', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-user form-control-feedback"></span></div>{hint}{error}',
        ])->textInput(['placeholder' => '请填写真实姓名'])->label(false); ?>
        <?= $form->field($model, 'mobile', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-phone form-control-feedback"></span></div>{hint}{error}',
        ])->textInput(['placeholder' => '请填写真实手机号码'])->label(false); ?>
        <?= $form->field($model, 'password', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span></div>{hint}{error}',
        ])->passwordInput(['placeholder' => '用户密码'])->label(false); ?>
        <?= $form->field($model, 'password_repetition', [
            'template' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-log-in form-control-feedback"></span></div>{hint}{error}',
        ])->passwordInput(['placeholder' => '确认密码'])->label(false); ?>
        <div class="form-group field-signupform-rememberme has-error">
            <input type="hidden" name="SignUpForm[rememberMe]" value="0">
            <input type="hidden" name="SignUpForm[group]" value="app">

            <label>
                <input type="checkbox" id="signupform-rememberme" name="SignUpForm[rememberMe]" value="1">
                <?= '我同意' . \yii\helpers\Html::a('《用户协议》', ['register-protocol'], [
                    'target' => '_blank',
                    'class' => 'blue'
                ])?>
            </label>
            <div class="help-block"><?= $model->getFirstError('rememberMe')?></div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <?= Html::submitButton('注册', ['class' => 'btn btn-primary btn-block']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="social-auth-links text-center">已有帐号？<?= Html::a('立即登录', ['login']); ?></div>
        <div class="social-auth-links text-center">
            <p><?= Html::encode(Yii::$app->debris->backendConfig('web_copyright')); ?></p>
        </div>
    </div>
    <!-- /.form-box -->
</div>
</body>
