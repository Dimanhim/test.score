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
use app\models\Save;
use app\models\Categories;
use app\models\Costs;
use app\models\CostsDefault;
use app\models\IncomesDefault;

class SaveController extends BaseController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $scores = Save::find()->all();
        return $this->render('index', [
            'scores' => $scores,
        ]);
    }
    public function actionAdd()
    {
        $model = new Save();
        if($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Накопление успешно добавлено!");
                return $this->redirect('index');
            }
        }
        return $this->render('add', [
            'model' => $model,
        ]);
    }
    public function actionView($id)
    {
        $model = Save::findOne($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    public function actionEdit($id)
    {
        $model = Save::findOne($id);
        if($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Накопление успешно отредактировано!");
                return $this->redirect('index');
            }
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }
    public function actionDelete($id)
    {
        $model = Save::findOne($id);
        if($model->delete()) {
            Yii::$app->session->setFlash('success', "Накопление успешно удалено!");
            return $this->redirect('index');
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }



}

