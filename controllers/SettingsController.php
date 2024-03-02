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
use app\models\Categories;
use app\models\Costs;
use app\models\CostsDefault;
use app\models\IncomesDefault;
use app\models\Settings;

class SettingsController extends BaseController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = Settings::find()->one();
        if($model->load(Yii::$app->request->post())) {
            $model->time_begin = strtotime($model->time_begin);
            $model->time_end = strtotime($model->time_end);
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Успешно сохранено!");
                return $this->redirect('index');
            }
            else {
                Yii::$app->session->setFlash('error', "Произошла ошибка сохранения!");
                return $this->redirect('index');
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}

