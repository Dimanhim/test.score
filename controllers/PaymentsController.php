<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Scores;
use app\models\Payments;
use app\models\Save;
use app\models\Categories;
use app\models\Costs;
use app\models\CostsDefault;
use app\models\IncomesDefault;

class PaymentsController extends BaseController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $scores = Payments::find()->all();
        return $this->render('index', [
            'scores' => $scores,
        ]);
    }
    public function actionAdd()
    {
        $model = new Payments();
        if($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Платеж успешно добавлен!");
                return $this->redirect('index');
            }
        }
        return $this->render('add', [
            'model' => $model,
        ]);
    }
    public function actionView($id)
    {
        $model = Payments::findOne($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    public function actionEdit($id)
    {
        $model = Payments::findOne($id);
        if($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Платеж успешно отредактирован!");
                return $this->redirect('index');
            }
        }
        $score = Save::findOne($id);
        return $this->render('edit', [
            'model' => $model,
            'score' => $score,
        ]);
    }
    public function actionDelete($id)
    {
        $model = Payments::findOne($id);
        if($model->delete()) {
            Yii::$app->session->setFlash('success', "Платеж успешно удален!");
            return $this->redirect('index');
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }



}

