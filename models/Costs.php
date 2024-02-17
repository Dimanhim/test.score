<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Costs extends ActiveRecord
{
    const DAY_FOR_STAT = 15;

    public $obligstory_payments;

    public function rules()
    {
        return [
            [['cost', 'score'], 'required'],
            [['name'], 'string'],
            [['id', 'category', 'category_child', 'costs_default', 'cost', 'score', 'check_for_days'], 'integer'],
            [['date', 'obligstory_payments'], 'safe'],
        ];
    }
    public function attributes()
    {
        return [
            'id',
            'name',
            'cost',
            'costs_default',
            'category',
            'category_child',
            'score',
            'date',
            'check_for_days',
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'cost' => 'Сумма',
            'costs_default' => 'Название по умолчанию',
            'category' => 'Категория',
            'category_child' => 'Подкатегория',
            'score' => 'Списать со счета',
            'date' => 'Дата',
            'check_for_days' => 'Учитывать в расходах по дням',
            'obligstory_payments' => 'Обязательные платежи',
        ];
    }
    public function afterSave($insert, $attributes)
    {
        Log::addLog(Log::TYPE_COST, $this->cost, 'Добавлен расход');
        return parent::afterSave($insert, $attributes);
    }
    public function getCatCosts($cat) {
        $price = 0;
        $ids = [];
        $id = Categories::findOne($cat);
        $set = new Settings();
        $ids[0] = $id->id;

        foreach(Categories::getSubCats($cat) as $sub_cat) {
            $ids[] = $sub_cat->id;
        }
        foreach(self::find()->where(['category' => $ids])->andWhere(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', $set->endDate])->all() as $cost) {
            $price = $price + $cost->cost;
        }
        return $price;
    }
    public function getCosts($check_for_days = false) {
        $set = new Settings();
        $price = 0;
        $query = self::find()->where(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', $set->endDate]);
        if($check_for_days) {
            $query->andWhere(['check_for_days' => 1]);
        }
        foreach($query->all() as $cost) {
            $price = $price + $cost->cost;
        }
        return $price;
    }
    public function getScore()
    {
        return $this->hasMany(Scores::className(), ['id' => 'score']);
    }
    public function getDateValue()
    {
        $date = date('d.m.Y', $this->date);
        return strtotime($date);
    }
    public static function getDaysForStatistycs()
    {
        $todayDate = strtotime(date('d.m.Y'));
        //$todayDate = strtotime('15.02.2021');
        $todayDay = date('d', $todayDate);
        if($todayDay >= self::DAY_FOR_STAT) {
            return date('t', $todayDate);
        } else {
            return date('t', $todayDate - 15 * 86400);
        }
        return false;
    }
    public static function getDayCost($date = null)
    {
        if(!$date) $date = strtotime(date('d.m.Y'));
        $lowDate = strtotime(date('d.m.Y', $date));
        $highDate = strtotime(date('d.m.Y')) + 84600;

        $dayCost = 0;
        if($costs = Costs::find()->where(['>=', 'date', $lowDate])->andWhere(['<=', 'date', $highDate])->andWhere(['check_for_days' => 1])->orderBy(['date' => SORT_DESC])->all()) {
            foreach($costs as $cost) {
                $dayCost += $cost->cost;
            }
        }
        return $dayCost;
    }

}

