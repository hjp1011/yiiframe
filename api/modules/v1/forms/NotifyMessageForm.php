<?php

namespace api\modules\v1\forms;

use Yii;
use yii\base\Model;

/**
 * Class NotifyMessageForm
 * @package backend\modules\base\forms
 * @author 古月 <21931118@qq.com>
 */
class NotifyMessageForm extends Model
{
    public $content;

    public $toManagerId;

    public $data;

    public function init()
    {
        $this->data = Yii::$app->services->backendMember->getMap();
        unset($this->data[Yii::$app->user->identity->member_id]);

        parent::init();
    }

    public function rules()
    {
        return [
            [['content', 'toManagerId'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'content' => '内容',
            'toManagerId' => '发送对象',
        ];
    }
}