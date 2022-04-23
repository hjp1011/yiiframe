<?php

echo "<?php\n";
?>

namespace addons\<?= $model->name;?>\services;

use common\components\Service;

/**
 * Class Application
 *
 * @package addons\<?= $model->name;?>\services
 */
class Application extends Service
{
    /**
     * @var array
     */
    public $childService = [

    ];
}