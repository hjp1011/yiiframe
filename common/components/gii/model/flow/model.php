<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
use addons\Flow\common\models\Metadata;
use addons\Flow\common\models\Status;
use addons\Flow\common\models\Works;
/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
    public $suggest;
    public $radioList;

    public function behaviors()
    {
        return [
            [
                'class' => \raoul2000\workflow\base\SimpleWorkflowBehavior::className(),
                'defaultWorkflowId' => '<?= $className ?>',
                'propagateErrorsToModel' => true,
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'attributes' => [
                <?= '\\' . ltrim($generator->baseClass, '\\') ?>::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                <?= '\\' . ltrim($generator->baseClass, '\\') ?>::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [<?= empty($rules) ? '' : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }

<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * {@inheritdoc}
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }


<?php endif; ?>

    /**
    * 关联用户
    *
    * @return \yii\db\ActiveQuery
    */
    public function getMember()
    {
        if (Yii::$app->services->devPattern->isGroup())
        return $this->hasOne(\addons\Merchants\common\models\Member::class, ['id' => 'member_id']);
        else if (Yii::$app->services->devPattern->isEnterprise())
        return $this->hasOne(\common\models\backend\Member::class, ['id' => 'member_id']);
    }
    /**
    * 关联分类
    *
    * @return \yii\db\ActiveQuery
    */
    public function getCate()
    {
        return $this->hasOne(<?= $className ?>Cate::class, ['id' => 'cate_id']);
    }
    public function beforeSave($insert)
    {
        if(Yii::$app->id == 'backend'||Yii::$app->id == 'merchant')
            $member_id = Yii::$app->user->id;
        else
            $member_id = Yii::$app->user->identity->member_id;
        if($insert){
            $this->member_id = $member_id;
            $this->merchant_id = \Yii::$app->user->identity->merchant_id;
            $this->content = $this->member->realname.',申请原因:'.$this->content;
        }
        if (!$insert){
            $arr = $this->log?$this->log:[];
            $log=["id"=>$member_id,"time"=>time(),"action"=>$this->status,"suggest"=>$this->suggest];
            array_push($arr,$log);
            $this->log = json_encode($arr);
            $status = explode('/',$this->status);
            $this->state = $status[1];
        }
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes)
    {
        if(Yii::$app->id == 'backend'||Yii::$app->id == 'merchant')
            $member_id = Yii::$app->user->id;
        else
            $member_id = Yii::$app->user->identity->member_id;
        // 增加关联的记录
        if ($insert) {
            $status = explode('/',$this->status);
            $works = new Works();
            $works = $works->loadDefaultValues();
            $works->content = $this->content;
            $works->member_id = $member_id;
            $works->workflow_id = $status[0];
            $works->state = $status[1];
            $works->work_id = $this->id;
            $works->model = '\addons\<?= $className ?>\common\models\<?= $className ?>';
            $works->merchant_id = \Yii::$app->user->identity->merchant_id;
            $works->save();

            $model = self::findOne($this->id);
            $model->state = $status[1];
            $model->save();
        }
        //更新工作状态
        if (!$insert){
            $status = explode('/',$this->status);
            $works = Works::find()->andWhere(['workflow_id'=>$status[0],'work_id'=>$this->id])->one();
            $works->state = $status[1];
            $audit = Status::find()->andWhere(['workflow_id' => $status[0], 'id' =>$status[1], 'merchant_id' =>\Yii::$app->user->identity->merchant_id ])->one();
            $metadata = Metadata::find()->andWhere(['workflow_id' => $status[0], 'status_id' =>$status[1], 'merchant_id' =>\Yii::$app->user->identity->merchant_id ])->asArray()->all();
            //某状态设置了元数据启用单独审核
            $flag = false;
            if($metadata){
            //记录审核人员ID: 1,2,5...
                if($works->audit_ids){
                    if($works->audit_id>0){
                        $audit_ids = explode(',', $works->audit_ids);
                        array_push($audit_ids, $works->audit_id);
                        $works->audit_ids = implode(',',$audit_ids);
                    }
                }else
                    $works->audit_ids = $works->audit_id;
                //记录结束
                $member_ids='';
                foreach ($metadata as $meta){
                    if($meta['key']=='audit_id') $audit_id = $meta['value'];
                    if($meta['key']=='member_id') $member_ids = $meta['value'];
                    if($meta['key']=='flag'&&$meta['value']==1) $flag=true;
                }
                //在单独审核的用户名单里情况
                if($flag&&in_array($this->member_id,explode(',',$member_ids))) {
                    $works->audit_id = 0;//审核用户置0
                    if($status[1]!='refused'){//流程状态置agree
                        $state = 'agree';
                        $model = self::findOne($this->id);
                        $model::updateAll(['state'=>$state,'status' =>$works->workflow_id.'/agree'], ['id' =>$this->id]);
                        $works->state=$state;
                    }
                }
                if(!$flag&&in_array($this->member_id,explode(',',$member_ids))) $works->audit_id = $audit_id;
                //不在单独审核用户名单里的情况
                if($flag&&!in_array($this->member_id,explode(',',$member_ids))) {
                    if($audit->type==0&&$audit->audit_id) $works->audit_id = $audit->audit_id;
                    else if($audit->type==1&&$audit->role_id)  $works->audit_id = Yii::$app->services->devPattern->getLeaderRoleId($member_id,$audit->role_id);
                }
                if(!$flag&&!in_array($this->member_id,explode(',',$member_ids))) {
                    if($audit->type==0&&$audit->audit_id) $works->audit_id = $audit->audit_id;
                    else if($audit->type==1&&$audit->role_id)  $works->audit_id = Yii::$app->services->devPattern->getLeaderRoleId($member_id,$audit->role_id);
                }
            }
            //某状态未设置元数据的情况
            if(!$metadata) {
                //记录审核人员ID: 1,2,5...
                if($works->audit_ids){
                    if($works->audit_id>0){
                        $audit_ids = explode(',', $works->audit_ids);
                        array_push($audit_ids, $works->audit_id);
                        $works->audit_ids = implode(',',$audit_ids);
                    }
                }else
                    $works->audit_ids = $works->audit_id;
                //记录结束
                if($audit->type==0&&$audit->audit_id)  $works->audit_id = $audit->audit_id;
                else if($audit->type==1&&$audit->role_id) $works->audit_id = Yii::$app->services->devPattern->getLeaderRoleId($member_id,$audit->role_id);
            }

            //判断流程是否结束,status=true表示已经结束
            $state=true;
            foreach ($this->getNextStatuses() as $key => $nextStatus) {
                $state = false;
            }
            if($state) $works->audit_id = 0;
            $works->save();
            //推送短信或消息
            $member = Yii::$app->services->devPattern->getMember($audit->audit_id);
            if($this->remind==0&&$works->audit_id>0&&$member->mobile &&  \yiiframe\addonhelper\AddonHelper::isInstall('AliyunSms')) Yii::$app->aliyunSmsService->sms->send($member->mobile, \addons\Flow\common\enums\WorkflowEnum::getValue($status[1]), 'audit');
            if($this->remind==1&&$works->audit_id>0 && \yiiframe\addonhelper\AddonHelper::isInstall('Notify')) Yii::$app->notifyService->notify->createMessage('[报修]'.$this->content, $member_id, $works->audit_id);

        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind()
    {
        $this->log = json_decode($this->log);
        parent::afterFind();
    }
}
