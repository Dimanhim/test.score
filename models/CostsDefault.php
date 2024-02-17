<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class CostsDefault extends ActiveRecord
{
    public $category_child;
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['id', 'category', 'category_child'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'category' => 'Категория',
            'category_child' => 'Подкатегория',
        ];
    }
}


