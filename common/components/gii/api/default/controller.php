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
class <?= StringHelper::basename($generator->controllerClass) ?> extends \api\controllers\OnAuthController
{
    public $modelClass = '';
    protected $authOptional = ['index'];
<?php foreach ($generator->getActionIDs() as $action): ?>

    public function action<?= Inflector::id2camel($action) ?>()
    {
        return 'Hello world';
    }

<?php endforeach; ?>
}
