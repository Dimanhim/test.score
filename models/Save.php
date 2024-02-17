<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Save extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['summa'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'summa' => 'Сумма',
        ];
    }
}
