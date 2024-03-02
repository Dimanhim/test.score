<?php

namespace app\controllers;

use app\models\Settings;
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
use app\models\User;
use app\models\FormRegistration;

class SiteController extends BaseController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $summa = [];
        $scores = Scores::find()->all();
        $cats = Categories::find()->where(['show_default' => 1])->orderBy('source ASC')->all();
        foreach($cats as $cat) {
            $set = new Settings();
            $costs = Costs::find()->where(['category' => $cat->id])->andWhere(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', $set->endDate])->all();
        }
        return $this->render('index', [
            'summa' => $summa,
            'scores' => $scores,
            'cats' => $cats,
        ]);
    }

    public function actionRegistration()
    {
        $model = new FormRegistration();
        if($model->load(\Yii::$app->request->post())){
            $user = new User();
            $user->username = $model->username;
            $user->password = $model->password;
            if($model->password == $model->password_2) {
                $user->password = \Yii::$app->security->generatePasswordHash($model->password);
                if($user->save()) {
                    Yii::$app->session->setFlash('success', "Поздравляем! Вы успешно зарегистрировались в системе!");
                    $login = new LoginForm();
                    $login->username = $model->username;
                    $login->password = $model->password;
                    if($login->login()) return $this->goHome();
                };
            }
            else {
                Yii::$app->session->setFlash('error', "Пароли не совпадают!");
                return $this->redirect('registration');
            }

        }
        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'empty';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
