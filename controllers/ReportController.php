<?php

namespace app\controllers;

use app\models\ReportModel;

class ReportController extends BaseController
{
    public function actionIndex()
    {
        $report = new ReportModel();

        return $this->render('index', [
            'report' => $report,
        ]);
    }

    public function actionIncomes()
    {
        $model = new ReportModel();
        $model->loadData(\Yii::$app->request->post());
        $data = $model->getIncomes();

        $salary = $model->getSalary();
        $pension = $model->getPension();

        return $this->render('report_incomes', [
            'dates' => $model->getDates($data),
            'values' => $model->getValues($data),
            'salary' => $model->getValues($salary),
            'pension' => $model->getValues($pension),
            'model' => $model,
        ]);
    }

    public function actionCats()
    {
        $model = new ReportModel();
        $model->loadData(\Yii::$app->request->post());
        $data = $model->getCategories();
        return $this->render('report_cats', [
            'model' => $model,
            'data' => $data,
            'dates' => $model->_dates,
        ]);
    }
}

