<?php
/**
 * This is the template for generating a controller class file.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\controller\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;
use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
class <?= StringHelper::basename($generator->controllerClass) ?> extends \api\controllers\OnAuthController
{
    public $modelClass = <?= StringHelper::basename($generator->modelClass) ?>::class;
    protected $authOptional = ['index'];

}
