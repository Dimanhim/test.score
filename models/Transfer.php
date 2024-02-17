<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;

class Transfer extends Model
{
    public $transfer_out;
    public $transfer_in;
    public $summa;

    public function rules()
    {
        return [
            [['id', 'transfer_out', 'transfer_in', 'summa', 'date'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'transfer_out' => 'Расход',
            'transfer_in' => 'Доход',
            'summa' => 'Сумма',
            'date' => 'Дата',
        ];
    }
    public function attributes()
    {
        return [
            'transfer_out',
            'transfer_in',
            'summa',
            'date',
        ];
    }

}


