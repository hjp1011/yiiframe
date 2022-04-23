<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components\gii\api;

use Yii;
use yii\db\ActiveRecord;
use yii\gii\CodeFile;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/**
 * This generator will generate a controller and one or a few action view files.
 *
 * @property array $actionIDs An array of action IDs entered by the user. This property is read-only.
 * @property string $controllerFile The controller class file path. This property is read-only.
 * @property string $controllerID The controller ID. This property is read-only.
 * @property string $controllerNamespace The namespace of the controller class. This property is read-only.
 * @property string $controllerSubPath The controller sub path. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\Generator
{
    /**
     * @var string the controller class name
     */
    public $controllerClass;
    public $modelClass;

    /**
     * @var string the base class of the controller
     */
    public $baseClass = 'yii\web\Controller';
    /**
     * @var string list of action IDs separated by commas or spaces
     */
    public $actions = 'index';


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Api Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'This generator helps you to quickly generate a new controller class with
            one or several controller actions and their corresponding views.';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['controllerClass','modelClass', 'actions', 'baseClass'], 'filter', 'filter' => 'trim'],
            [['controllerClass', 'baseClass'], 'required'],
            ['controllerClass', 'match', 'pattern' => '/^[\w\\\\]*Controller$/', 'message' => 'Only word characters and backslashes are allowed, and the class name must end with "Controller".'],
            ['controllerClass', 'validateNewClass'],
            ['baseClass', 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            ['actions', 'match', 'pattern' => '/^[a-z][a-z0-9\\-,\\s]*$/', 'message' => 'Only a-z, 0-9, dashes (-), spaces and commas are allowed.'],
            ['viewPath', 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'modelClass' => 'Model Class',
            'baseClass' => 'Base Class',
            'controllerClass' => 'Controller Class',
            'actions' => 'Action IDs',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function requiredTemplates()
    {
        return [
            'controller.php',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function stickyAttributes()
    {
        return ['baseClass'];
    }

    /**
     * {@inheritdoc}
     */
    public function hints()
    {
        return [
            'modelClass' => 'This is the ActiveRecord class associated with the table that CRUD will be built upon.
                You should provide a fully qualified class name, e.g., <code>app\models\Post</code>.',
            'controllerClass' => 'This is the name of the controller class to be generated. You should
                provide a fully qualified namespaced class (e.g. <code>app\controllers\PostController</code>),
                and class name should be in CamelCase ending with the word <code>Controller</code>. Make sure the class
                is using the same namespace as specified by your application\'s controllerNamespace property.',
            'actions' => 'Provide one or multiple action IDs to generate empty action method(s) in the controller. Separate multiple action IDs with commas or spaces.
                Action IDs should be in lower case. For example:
                <ul>
                    <li><code>index</code> generates <code>actionIndex()</code></li>
                    <li><code>create-order</code> generates <code>actionCreateOrder()</code></li>
                </ul>',
            'baseClass' => 'This is the class that the new controller class will extend from. Please make sure the class exists and can be autoloaded.',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function successMessage()
    {
        return 'The controller has been generated successfully.' . $this->getLinkToTry();
    }

    /**
     * This method returns a link to try controller generated
     * @see https://github.com/yiisoft/yii2-gii/issues/182
     * @return string
     * @since 2.0.6
     */
    private function getLinkToTry()
    {
        if (strpos($this->controllerNamespace, Yii::$app->controllerNamespace) !== 0) {
            return '';
        }

        $actions = $this->getActionIDs();
        if (in_array('index', $actions, true)) {
            $route = $this->getControllerSubPath() . $this->getControllerID() . '/index';
        } else {
            $route = $this->getControllerSubPath() . $this->getControllerID() . '/' . reset($actions);
        }
        return ' You may ' . Html::a('try it now', Yii::$app->getUrlManager()->createUrl($route), ['target' => '_blank', 'rel' => 'noopener noreferrer']) . '.';
    }
    /**
     * Checks if model class is valid
     */
    public function validateModelClass()
    {
        /* @var $class ActiveRecord */
        $class = $this->modelClass;
        $pk = $class::primaryKey();
        if (empty($pk)) {
            $this->addError('modelClass', "The table associated with $class must have primary key(s).");
        }
    }
    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $files = [];

        $files[] = new CodeFile(
            $this->getControllerFile(),
            $this->render('controller.php')
        );



        return $files;
    }

    /**
     * Normalizes [[actions]] into an array of action IDs.
     * @return array an array of action IDs entered by the user
     */
    public function getActionIDs()
    {
        $actions = array_unique(preg_split('/[\s,]+/', $this->actions, -1, PREG_SPLIT_NO_EMPTY));
        sort($actions);

        return $actions;
    }

    /**
     * @return string the controller class file path
     */
    public function getControllerFile()
    {
        return Yii::getAlias('@' . str_replace('\\', '/', $this->controllerClass)) . '.php';
    }

    /**
     * @return string the controller ID
     */
    public function getControllerID()
    {
        $name = StringHelper::basename($this->controllerClass);
        return Inflector::camel2id(substr($name, 0, strlen($name) - 10));
    }

    /**
     * This method will return sub path for controller if it
     * is located in subdirectory of application controllers dir
     * @see https://github.com/yiisoft/yii2-gii/issues/182
     * @since 2.0.6
     * @return string the controller sub path
     */
    public function getControllerSubPath()
    {
        $subPath = '';
        $controllerNamespace = $this->getControllerNamespace();
        if (strpos($controllerNamespace, Yii::$app->controllerNamespace) === 0) {
            $subPath = substr($controllerNamespace, strlen(Yii::$app->controllerNamespace));
            $subPath = ($subPath !== '') ? str_replace('\\', '/', substr($subPath, 1)) . '/' : '';
        }
        return $subPath;
    }

    /**
     * @param string $action the action ID
     * @return string the action view file path
     */
    public function getViewFile($action)
    {
        if (empty($this->viewPath)) {
            return Yii::getAlias('@app/views/' . $this->getControllerSubPath() . $this->getControllerID() . "/$action.php");
        }

        return Yii::getAlias(str_replace('\\', '/', $this->viewPath) . "/$action.php");
    }

    /**
     * @return string the namespace of the controller class
     */
    public function getControllerNamespace()
    {
        $name = StringHelper::basename($this->controllerClass);
        return ltrim(substr($this->controllerClass, 0, - (strlen($name) + 1)), '\\');
    }
}
