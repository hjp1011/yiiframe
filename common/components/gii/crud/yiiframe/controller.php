<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use yii\helpers\Json;
use common\traits\Curd;
use common\controllers\BaseController;
use <?= ltrim($generator->modelClass, '\\') ?>;

/**
* <?= $modelClass . "\n" ?>
*
* Class <?= $controllerClass . "\n" ?>
* @package <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) . "\n" ?>
*/
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    use Curd;

    /**
    * @var <?= $modelClass . "\n" ?>
    */
    public $modelClass = <?= $modelClass ?>::class;


}
