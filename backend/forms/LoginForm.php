<?php

namespace backend\forms;

use yiiframe\addonhelper\AddonHelper;
use Yii;
use common\helpers\StringHelper;
use common\models\backend\Member;

/**
 * Class LoginForm
 * @package backend\forms
 * @author YiiFrame <21931118@qq.com>
 */
class LoginForm extends \common\models\forms\LoginForm
{
    /**
     * 校验验证码
     *
     * @var
     */
    public $verifyCode;

    /**
     * 默认登录失败3次显示验证码
     *
     * @var int
     */
    public $attempts = 3;

    /**
     * @var bool
     */
    public $rememberMe = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['password', 'validateIp'],
            //[['password'], 'match', 'pattern' => '/^.*(?=.{6,})(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*? ]).*$/','message'=>'请修改密码，密码必须包含大小写字母数字和特殊字符'],
            ['verifyCode', 'captcha', 'on' => 'captchaRequired'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app','用户名'),
            'rememberMe' => Yii::t('app','记住我'),
            'password' => Yii::t('app','密码'),
            'verifyCode' => Yii::t('app','验证码'),
        ];
    }

    /**
     * 验证ip地址是否正确
     *
     * @param $attribute
     * @throws \yii\base\InvalidConfigException
     */
    public function validateIp($attribute)
    {
        $ip = Yii::$app->request->userIP;
        $allowIp = Yii::$app->debris->backendConfig('sys_allow_ip');
        if (!empty($allowIp)) {
            $ipList = StringHelper::parseAttr($allowIp);

            if (!in_array($ip, $ipList)) {
                // 记录行为日志
//                if(AddonHelper::isInstall('Monitoring'))
//                    Yii::$app->monitoringService->log->create('login', '限制IP登录', false);
                $this->addError($attribute, '登录失败，请联系管理员');
            }
        }
    }

    /**
     * @return mixed|null|static
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Member::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * 验证码显示判断
     */
    public function loginCaptchaRequired()
    {
        if (Yii::$app->session->get('loginCaptchaRequired') >= $this->attempts) {
            $this->setScenario("captchaRequired");
        }
    }

    /**
     * 登录
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function login()
    {
        if ($this->validate() && Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0)) {
            Yii::$app->session->remove('loginCaptchaRequired');
            return true;
        }
        $counter = Yii::$app->session->get('loginCaptchaRequired') + 1;
        Yii::$app->session->set('loginCaptchaRequired', $counter);
        return false;
    }
}