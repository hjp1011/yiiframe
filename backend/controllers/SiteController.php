<?php

namespace backend\controllers;

use yiiframe\plugs\common\AddonHelper;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\forms\LoginForm;
use backend\forms\SignUpForm;
use yii\web\NotFoundHttpException;

/**
 * Class SiteController
 * @package backend\controllers
 * @author YiiFrame <21931118@qq.com>
 */
class SiteController extends Controller
{
    /**
     * 默认布局文件
     *
     * @var string
     */
    public $layout = "default";

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login','register','register-protocol', 'error', 'captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 6, // 最大显示个数
                'minLength' => 6, // 最少显示个数
                'padding' => 5, // 间距
                'height' => 32, // 高度
                'width' => 100, // 宽度
                'offset' => 4, // 设置字符偏移量
                'backColor' => 0xffffff, // 背景颜色
                'foreColor' => 0x62a8ea, // 字体颜色
            ]
        ];
    }

    /**
     * 登录
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->loginCaptchaRequired();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    /**
     * 注册
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRegister()
    {
        // 判断开放注册
        if (empty(Yii::$app->debris->addonConfig('Member')['member_register_is_open'])){
            throw new NotFoundHttpException('未开放注册，请稍后再试');
        }

        $model = new SignUpForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($member = $model->register()) {
                return $this->redirect(['login']);
            }

            return $this->redirect(['register']);
        }

        return $this->render($this->action->id, [
            'model' => $model,
        ]);
    }

    /**
     * 注册协议
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRegisterProtocol()
    {
        // 判断开放注册
        if (empty(Yii::$app->debris->addonConfig('Member')['member_register_is_open'])){
            throw new NotFoundHttpException('找不到页面');
        }

        return $this->render($this->action->id, []);
    }
    /**
     * @return \yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    //关闭站点
    public function actionOffline()
    {
        return $this->renderPartial('offline', [
            'title' => '系统维护中...'
        ]);
    }
}
