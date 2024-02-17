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

class CostsDefaultController extends Controller
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

    public function actionIndex()
    {
        $model = CostsDefault::find()->all();
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    public function actionAdd()
    {
        $model = new CostsDefault();
        if($model->load(Yii::$app->request->post())) {
            $model->category = $model->category_child ? $model->category_child : $model->category;
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Расход успешно добавлен!");
                return $this->redirect('index');
            }
        }
        return $this->render('add', [
            'model' => $model,
        ]);
    }
    public function actionDelete($id)
    {
        $model = CostsDefault::findOne($id);
        if($model->delete()) {
            Yii::$app->session->setFlash('success', "Расход по умолчанию успешно удален!");
            return $this->redirect('index');
        }
        else {
            Yii::$app->session->setFlash('error', "Произошла ошибка удаления!");
            return $this->redirect('index');
        }
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
