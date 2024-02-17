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
use app\models\Transfer;

class TransferController extends Controller
{
    public function beforeAction($action)
    {
        $user = Yii::$app->user;
        if($user->isGuest AND $this->action->id !== 'login')
        {
            $user->loginRequired();
        }
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionAdd()
    {
        $model = new Transfer();

        if($model->load(Yii::$app->request->post())) {
            $score_out = Scores::findOne($model->transfer_out);
            $price_out = $score_out->summa;
            $score_in = Scores::findOne($model->transfer_in);
            $price_in = $score_in->summa;

            $score_out->summa = $price_out - $model->summa;
            $score_in->summa = $price_in + $model->summa;
            if($score_out->save() && $score_in->save()) {
                Yii::$app->session->setFlash('success', "Перевод успешно выполнен!");
                return $this->redirect('add');
            }
        }
        return $this->render('add', [
            'model' => $model,
        ]);
    }
    /*public function actionAdd()
    {
        $model = new Scores();
        if($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Счет успешно добавлен!");
                return $this->redirect('index');
            }
        }
        return $this->render('add', [
            'model' => $model,
        ]);
    }*/
    public function actionView($id)
    {
        $model = Scores::findOne($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    public function actionEdit($id)
    {
        $model = Scores::findOne($id);
        if($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Счет успешно отредактирован!");
                return $this->redirect('index');
            }
        }
        $score = Scores::findOne($id);
        return $this->render('edit', [
            'model' => $model,
            'score' => $score,
        ]);
    }
    public function actionDelete($id)
    {
        $model = Scores::findOne($id);
        if($model->delete()) {
            Yii::$app->session->setFlash('success', "Счет успешно удален!");
            return $this->redirect('index');
        }
        return $this->render('view', [
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
