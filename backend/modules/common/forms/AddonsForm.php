<?php

namespace backend\modules\common\forms;

use common\helpers\ArrayHelper;
use common\models\common\Addons;

/**
 * Class AddonsForm
 * @package backend\modules\common\forms
 * @author YiiFrame <21931118@qq.com>
 */
class AddonsForm extends Addons
{
    /**
     * @var
     */
    public $install = 'Install';

    /**
     * @var
     */
    public $uninstall = 'UnInstall';

    /**
     * @var
     */
    public $upgrade = 'Upgrade';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['install', 'uninstall', 'upgrade', 'author'], 'required'],
        ], parent::rules());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'install' => \Yii::t('app','安装文件'),
            'uninstall' =>  \Yii::t('app','卸载文件'),
            'upgrade' =>  \Yii::t('app','升级文件'),
        ], parent::attributeLabels());
    }
}
