<?php

namespace app\models;

use yii\base\Model;

class ReportModel extends Model
{
    public $_incomes = [];
    public $_costs = [];
    public $date_from;
    public $date_to;
    public $date_from_ts;
    public $date_to_ts;
    public $category_ids = null;
    public $_dates = [];

    /**
     *
     */
    public function init()
    {
        $this->initModel();
        return parent::init();
    }

    public function initModel()
    {
        if(!$this->date_from and !$this->date_to) {
            $this->date_from = date('d.m.Y', time() - 7 * 86400);
            $this->date_to = date('d.m.Y');
        }
        $this->date_from_ts = strtotime($this->date_from);
        $this->date_to_ts = strtotime($this->date_to);
    }

    public function loadData($data)
    {
        $this->load($data);
        $this->initModel();
        $this->setDates();
    }

    public function rules()
    {
        return [
            [['date_from', 'date_to','date_from_ts', 'date_to_ts', 'category_ids'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'date_from' => 'От',
            'date_to' => 'До',
            'category_ids' => 'Категории',
        ];
    }

    public function setDates()
    {
        return [];
        if($this->date_from_ts and $this->date_to_ts) {
            $date_ts = $this->date_from_ts;
            // первый день этого месяца
            $firstDayOfMonth = strtotime(date('Y-m-01', $date_ts));

            // первый день следующего месяца
            $month = date('n', $date_ts) + 1;
            $year = date('y', $date_ts);
            $firstDayOfNextMonth = mktime(0,0,0, $month, 1, $year);
        }

    }

    /**
     * @return array
     */
    public function getIncomes()
    {
        $this->_incomes = [];
        $incomes = Incomes::find()->where(['between', 'date', $this->date_from_ts, $this->date_to_ts])->andWhere(['not', ['category' => 46]])->all();
        if($incomes) {
            foreach($incomes as $income) {
                $key = '01.'.date('m.Y', $income->date);
                $this->_incomes[$key] += $income->income;
            }
        }
        return $this->_incomes;
    }

    public function getSalary()
    {
        $this->_incomes = [];
        if($this->date_from_ts and $this->date_to_ts) {
            $incomes = Incomes::find()->where(['between', 'date', $this->date_from_ts, $this->date_to_ts])->andWhere(['category' => 16])->all();
        }
        else {
            $incomes = Incomes::find()->where(['category' => 16])->all();
        }
        if($incomes) {
            foreach($incomes as $income) {
                $key = '01.'.date('m.Y', $income->date);
                $this->_incomes[$key] += $income->income;
            }
        }
        return $this->_incomes;
    }

    public function getPension()
    {
        $this->_incomes = [];
        if($this->date_from_ts and $this->date_to_ts) {
            $incomes = Incomes::find()->where(['between', 'date', $this->date_from_ts, $this->date_to_ts])->andWhere(['category' => 46])->all();
        }
        else {
            $incomes = Incomes::find()->where(['category' => 46])->all();
        }
        if($incomes) {
            foreach($incomes as $income) {
                $key = '01.'.date('m.Y', $income->date);
                $this->_incomes[$key] += $income->income;
            }
        }
        return $this->_incomes;
    }

    public function setCategoriesIds()
    {
        $ids = [];
        if($this->category_ids) {
            foreach($this->category_ids as $categoryId) {
                if($categories = Categories::findAll(['parent' => $categoryId])) {
                    foreach($categories as $category) {
                        $ids[] = $category->id;
                    }
                }
                else {
                    $ids[] = $categoryId;
                }
            }
        }
        $this->category_ids = array_unique($ids);
    }

    public function getCategories()
    {
        /*return [
            ['name' => 'Категория 11', 'data' => [5,7,9,3,1,5,6,4,8,9,7,5]],
            ['name' => 'Категория 21', 'data' => [6,5,7,8,1,2,3,9,8,5,4,6]],
            ['name' => 'Категория 31', 'data' => [5,6,7,8,9,2,5,7,8,4,5,6]]
        ];*/
        $this->setCategoriesIds();
        $categoryData = [];
        if($this->category_ids) {
            foreach($this->category_ids as $category_id) {
                if($category = Categories::findOne($category_id)) {
                    // если эта категория родительская и в ней нет расходов
                    $eachData = ['name' => $category->fullName, 'data' => []];
                    // не выбирает нихуя

                    if($costs = Costs::find()->where(['between', 'date', $this->date_from_ts, $this->date_to_ts])->andWhere(['category' => $category->id])->all()) {
                        foreach($costs as $cost) {
                            $key = '01.'.date('m.Y', $cost->date);
                            if(!array_key_exists($key, $eachData['data'])) {
                                $eachData['data'][$key] = $cost->cost;
                            }
                            else {
                                $eachData['data'][$key] += $cost->cost;
                            }
                        }
                    }
                }
                echo "<pre>";
                print_r($eachData);
                echo "</pre>";
                exit;
                $categoryData[] = $eachData;
            }
        }
        return $data;
    }

    public function getValues($reportData)
    {
        $data = [];
        if($reportData) {
            foreach($reportData as $reportItem) {
                $data[] = $reportItem;
            }
        }
        return $data;
    }

    public function getDates($reportData)
    {
        $data = [];
        if($reportData) {
            foreach($reportData as $reportKey => $reportItem) {
                $data[] = $reportKey;
            }
        }
        return $data;
    }
}
