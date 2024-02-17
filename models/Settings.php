<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Settings extends ActiveRecord
{
    public function rules()
    {
        return [
            [['id', 'time_begin', 'time_end', 'month_limit', 'notes_1', 'notes_2', 'notes_3', 'notes_4'], 'safe'],
        ];
    }
    public function attributes()
    {
        return [
            'id',
            'time_begin',
            'time_end',
            'month_limit',
            'notes_1',
            'notes_2',
            'notes_3',
            'notes_4',
        ];
    }
    public function attributeLabels()
    {
        return [
            'time_begin' => 'С даты',
            'time_end' => 'До даты',
            'month_limit' => 'Лимит расходов в месяц',
            'notes_1' => 'Общие заметки',
            'notes_2' => 'Заметки по покупкам',
            'notes_3' => 'Заметки по инвестициям',
            'notes_4' => 'Другие заметки',
        ];
    }
    public function getBeginDate()
    {
        return self::find()->one()->time_begin;
    }
    public function getEndDate()
    {
        return self::find()->one()->time_end;
    }

}


