<?php

namespace app\models;

use Faker\Provider\Payment;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "logs".
 *
 * @property int $id
 * @property int $type_id
 * @property int $value
 * @property string $desc
 * @property int $created_at
 * @property int $updated_at
 */
class Log extends \yii\db\ActiveRecord
{
    const TYPE_COST     = 1;
    const TYPE_INCOME   = 2;
    const TYPE_TRANSFER = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'value'], 'required'],
            [['type_id', 'value', 'score_id'], 'integer'],
            [['name', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Тип операции',
            'value' => 'Сумма',
            'name' => 'Название',
            'desc' => 'Описание',
            'score_id' => 'Счет',
            'created_at' => 'Дата',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_COST     => 'Расход',
            self::TYPE_INCOME   => 'Доход',
            self::TYPE_TRANSFER => 'Перевод',
        ];
    }

    /**
     * @return bool|mixed
     */
    public function getTypeName()
    {
        $types = self::getTypes();
        if(array_key_exists($this->type_id, $types)) return $types[$this->type_id];
        return false;
    }

    public function getScore()
    {
        return $this->hasOne(Scores::className(), ['id' => 'score_id']);
    }

    public static function addLog($type_id, $value, $name, $score_id, $obligstory_payments = null)
    {
        $log = new self();
        $log->type_id = $type_id;
        $log->value = $value;
        $log->name = $name;
        $log->score_id = $score_id;
        switch ($type_id) {
            case self::TYPE_COST : {
                if($score = $log->score) {
                    $message = "Добавлен расход {$log->name} со счета {$score->name} на сумму {$log->value}";
                    if($obligstory_payments and ($payment = Payments::findOne($obligstory_payments))) {
                        $message .= ' из обязательных платежей '.$payment->name;
                    }
                    $log->desc = $message;
                }
            }
                break;
            case self::TYPE_INCOME : {
                if($score = $log->score) {
                    $log->desc = "Добавлен доход {$log->name} на счет {$score->name} на сумму {$log->value}";
                }
            }
                break;
            case self::TYPE_TRANSFER : {
                if($score = $log->score) {
                    $log->desc = "Перевод {$score->name} на сумму {$log->value}";
                }
            }
                break;
        }
        return $log->save();
    }
}
