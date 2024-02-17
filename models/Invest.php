<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "invest".
 *
 * @property int $id
 * @property int $invest_id
 * @property int $summ
 * @property int $created_at
 */
class Invest extends \yii\db\ActiveRecord
{
    public $updated_at;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invest';
    }

    /**
     * {@inheritdoc}
     */
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
            [['invest_id', 'summ'], 'required'],
            [['invest_id', 'summ', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invest_id' => 'Счет',
            'summ' => 'Сумма',
            'created_at' => 'Дата создания',
        ];
    }

    public function getInvests()
    {
        return [
            1 => 'Брокерский счет',
            2 => 'ИИС',
        ];
    }
    public function getInvestName()
    {
        return $this->invests[$this->invest_id];
    }
    public function investPrice($invest_id)
    {
        $count = 0;
        if($model = self::findAll(['invest_id' => $invest_id])) {
            foreach ($model as $value) {
                $count += $value->summ;
            }
        }
        return $count;
    }
}
