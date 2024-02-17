<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property int $id
 * @property int $type_id
 * @property int $amount
 * @property string $descriptiom
 * @property int $created_at
 * @property int $updated_at
 */
class Log extends \yii\db\ActiveRecord
{
    const TYPE_COST = 1;
    const TYPE_INCOME = 2;
    const TYPE_TRASSACTION = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs';
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'amount'], 'required'],
            [['type_id', 'amount'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['descriptiom'], 'string', 'max' => 255],
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
            'amount' => 'Цена',
            'descriptiom' => 'Описание',
            'created_at' => 'Дата',
            'updated_at' => 'Updated At',
        ];
    }
    public static function addLog($type_id, $amount, $description = null)
    {
        return true;
        $model = new self();
        $model->type_id = $type_id;
        $model->amount = $amount;
        if($description) $model->descriptiom = $description;
        return $model->save();
    }
}
