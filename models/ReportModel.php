<?php

namespace app\models;

use yii\base\Model;

class ReportModel extends Model
{
    public $_incomes = [];
    public $date_from;
    public $date_to;
    public $date_from_ts;
    public $date_to_ts;

    /**
     *
     */
    public function init()
    {
        if(!$this->date_from and !$this->date_to) {
            $date_from = date('d.m.Y', time() - 365 * 86400);
            $date_to = date('d.m.Y');
        }
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->date_from_ts = strtotime($date_from);
        $this->date_to_ts = strtotime($date_to);
        return parent::init();
    }

    public function rules()
    {
        return [
            [['date_from', 'date_to','date_from_ts', 'date_to_ts'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'date_from' => 'От',
            'date_to' => 'До',
        ];
    }

    /**
     * @return array
     */
    public function getIncomes()
    {
        $this->_incomes = [];
        if($this->date_from_ts and $this->date_to_ts) {
            $incomes = Incomes::find()->where(['between', 'date', $this->date_from_ts, $this->date_to_ts])->andWhere(['not', ['category' => 46]])->all();
        }
        else {
            $incomes = Incomes::find()->where(['not', ['category' => 46]])->all();
        }
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
