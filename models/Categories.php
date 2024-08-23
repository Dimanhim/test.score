<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Categories extends ActiveRecord
{
    const COST = 0;
    const INCOME = 1;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            [['id', 'date', 'parent', 'source', 'show_default'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'date' => 'Дата создания',
            'parent' => 'Родительская категория',
            'source' => 'Источник',
            'show_default' => 'Показывать',
        ];
    }
    public function getParentModel()
    {
        return $this->hasOne(self::className(), ['id' => 'parent']);
    }
    public function getParentCats($source)
    {
        return self::find()->where(['parent' => null, 'source' => $source, 'show_default' => 1])->all();
    }
    public function getSubCats($id)
    {
        return self::find()->where(['parent' => $id])->all();
    }
    public function getCategoryName($id)
    {
        return self::findOne($id)->name;
    }
    public function isParent()
    {

    }
    public function getFullName()
    {
        if($this->parentModel) {
            return $this->parentModel->name.' - '.$this->name;
        }
        return $this->name;
    }
    public function getArraySource()
    {
        return [
            self::COST => 'Расходы',
            self::INCOME => 'Доходы',
        ];
    }
    public function getSource()
    {
        if($source == self::COST) return 'Расходы';
        if($source == self::INCOME) return 'Доходы';
        return false;
    }

    public static function getList()
    {
        $data = [];
        if($cats = self::find()->all()) {
            foreach($cats as $cat) {
                $catName = '';
                if($cat->parentModel) {
                    $catName .= $cat->parentModel->name.' - ';
                }
                $catName .= $cat->name;
                $data[$cat->id] = $catName;
            }
        }

        return $data;
    }
}

