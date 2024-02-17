<?php

namespace app\models;
use app\models\Payments;
use app\models\Save;
use Yii;
use yii\db\ActiveRecord;

class Scores extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            [['id', 'is_check', 'id_default', 'summa', 'credit_limit'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'id_default' => 'По умолчанию',
            'is_check' => 'Учитывать при подсчете',
            'summa' => 'Сумма',
            'credit_limit' => 'Кредитный лимит',
        ];
    }
    public function getScoreName($id)
    {
        return self::findOne($id)->name;
    }
    public function changeScore($cost, $id)
    {
        $model = self::findOne($id);
        $summa = $model->summa + $cost;
        $model->summa = $summa;
        if($model->save()) return true;
        return false;
    }
    public function getAccessMoney()
    {
        $summa = 0;
        $scores = self::find()->all();
        foreach($scores as $score) {
            if($score->credit_limit) {
                $summa -= ($score->credit_limit - $score->summa);
            }
            elseif($score->is_check ==1) {
                $summa += $score->summa;
            }
        }
        $summa = Scores::getActualMoney($summa);
        return $summa;
    }
    public function getActualMoney($summa)
    {
        $count = 0;
        foreach(Save::find()->all() as $v) {
            $count += $v->summa;
        }
        foreach(Payments::find()->all() as $v) {
            $count += $v->summa;
        }
        return $summa - $count;
    }
    public function getScore($id, $default = 0)
    {
        return $id;
    }
    public function getTimeBeginMonth()
    {
        $month = date('m');
        $year = date('Y');
        return mktime(0,0,0, $month,1,$year);
    }
}
