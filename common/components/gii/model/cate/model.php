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
use common\enums\StatusEnum;
use common\helpers\ArrayHelper;
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
    * Gets query for [[<?= $name ?>]].
    *
    * @return <?= $relationsClassHints[$name] . "\n" ?>
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
    * 获取树状数据
    */
    public static function getTree()
    {
        $cates = self::find()
        ->where(['status' => StatusEnum::ENABLED])
        ->asArray()
        ->all();
        return ArrayHelper::itemsMerge($cates);
    }
    /**
    * 获取下拉
    */
    public static function getDropDownForEdit($id = '')
    {
        $list = self::find()
        ->where(['>=', 'status', StatusEnum::DISABLED])
        ->andFilterWhere(['merchant_id' => \Yii::$app->user->identity->merchant_id])
        ->andFilterWhere(['<>', 'id', $id])
        ->select(['id', 'title', 'pid', 'level'])
        ->orderBy('sort asc')
        ->asArray()
        ->all();

        $models = ArrayHelper::itemsMerge($list);
        $data = ArrayHelper::map(ArrayHelper::itemsMergeDropDown($models), 'id', 'title');
        return ArrayHelper::merge([0 => Yii::t('app','Top classification')], $data);
    }

    public static function getDropDown()
    {
        $models = self::find()
        ->where(['status' => StatusEnum::ENABLED])
        ->andFilterWhere(['merchant_id' => \Yii::$app->user->identity->merchant_id])
        ->orderBy('sort asc,id asc')
        ->asArray()
        ->all();

        $models = ArrayHelper::itemsMerge($models);
        return ArrayHelper::map(ArrayHelper::itemsMergeDropDown($models), 'id', 'title');
    }

    public static function getValue($key): string
    {
        return static::getMap()[$key] ?? '';
    }

    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'pid']);
    }
    public function beforeSave($insert)
    {
        $this->merchant_id = \Yii::$app->user->identity->merchant_id;
        return parent::beforeSave($insert);
    }
}
