<?php

namespace app\controllers;

use app\models\Payments;
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
use app\models\Settings;
use app\models\CostsDefault;
use app\models\IncomesDefault;
use yii\data\Pagination;
use app\models\CostsSearch;

class CostsController extends Controller
{

   /* public function beforeAction($action)
    {
        $user = Yii::$app->user;
        if($user->isGuest AND $this->action->id !== 'login')
        {
            $user->loginRequired();
        }
        return true;
    }*/
   const DAYS = 30;
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


    //------------------------------------- РАСХОДЫ
    public function actionIndex()
    {
        $searchModel = new CostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        /*$set = new Settings();
        $model = Costs::find()->where(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', ($set->endDate + 86399)])->orderBy('date DESC');

        // Пагинация
        $pagination = new Pagination(
            [
                'defaultPageSize' => 10,
                'totalCount' => $model->count(),
            ]
        );
        $model = $model->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'model' => $model,
            'pagination' => $pagination,
        ]);*/
    }
    public function actionCat($id)
    {
        $set = new Settings();
        $model = Costs::find()->where(['category' => $id])->andWhere(['>=', 'date', $set->beginDate])->andWhere(['<', 'date', $set->endDate]);

        // Пагинация
        $pagination = new Pagination(
            [
                'defaultPageSize' => 10,
                'totalCount' => $model->count(),
            ]
        );
        $model = $model->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('cat', [
            'model' => $model,
            'pagination' => $pagination,
        ]);
    }
    public function actionAdd()
    {
        $model = new Costs();
        $model->check_for_days = 1;
        if($model->load(Yii::$app->request->post())) {
            if($model->costs_default != 0) {
                $costsDefault = CostsDefault::findOne($model->costs_default);
                $model->name = $costsDefault->name;
                $model->category = $costsDefault->category;
                $model->category_child = 0;
                if($costsDefault->id == 16) $model->score = 1;
            }
            else {
                $model->costs_default = 0;
            }
            if($model->obligstory_payments) {
                $payment = Payments::findOne($model->obligstory_payments);
                $payment->summa = $payment->summa - $model->cost;
                $payment->save();
            }

            if($model->category_child) $model->category = $model->category_child;
            $model->date = strtotime($model->date) + 1;
            if($model->save()) {
                if(Scores::changeScore('-'.$model->cost, $model->score)) {
                    Yii::$app->session->setFlash('success', "Расход успешно добавлен!");
                    return $this->redirect('index');
                }
                else {
                    Yii::$app->session->setFlash('error', "Произошла ошибка сохранения!");
                    return $this->redirect('index');
                }
            }
        }
        return $this->render('add', [
            'model' => $model,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = Costs::findOne($id);
        if($model->load(Yii::$app->request->post())) {
            $model->date = strtotime($model->date) + 1;
            if($model->save()) {
                Yii::$app->session->setFlash('success', "Расход успешно отредактирован!");
                return $this->redirect(Yii::$app->request->referrer);
            }
            else {
                Yii::$app->session->setFlash('error', "Произошла ошибка сохранения!");
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        $costs = Costs::findOne($id);
        return $this->render('edit', [
            'model' => $model,
            'costs' => $costs,
        ]);
    }
    public function actionDelete($id)
    {
        $model = Costs::findOne($id);
        if($model->delete()) {
            Yii::$app->session->setFlash('success', "Расход успешно удален!");
            return $this->redirect('index');
        }
        else {
            Yii::$app->session->setFlash('error', "Произошла ошибка удаления!");
            return $this->redirect('index');
        }
    }

    public function actionDays()
    {
        $highDate = strtotime(date('d.m.Y')) + 84600;
        $lowDate = $highDate - Costs::getDaysForStatistycs() * 84600;

        $costs = Costs::find()->where(['>=', 'date', $lowDate])->andWhere(['<=', 'date', $highDate])->andWhere(['check_for_days' => 1])->orderBy(['date' => SORT_DESC])->all();
        $datesArray = [];
        $resultArray = [];
        foreach($costs as $cost) {
            if(!in_array($cost->dateValue, $datesArray)) {
                $datesArray[] = $cost->dateValue;
                $resultArray[$cost->dateValue] = $cost->cost;
            }
            else {
                $resultArray[$cost->dateValue] += $cost->cost;
            }
        }
        return $this->render('days', [
            'results' => $resultArray,
            'days' => self::DAYS,
        ]);
    }
    public function actionEachDay($date)
    {
        $costs = Costs::find()->where(['<=', 'date', ($date + 86400)])->andWhere(['>=', 'date', $date])->all();
        return $this->render('each-day', [
            'costs' => $costs,
        ]);
    }

//---AJAX
    public function actionGetSubCats()
    {
        $id = Yii::$app->request->post('id');
        if($id) {
            $option = '';
            $cats = Categories::find()->where(['parent' => $id, 'show_default' => 1])->all();
            if($cats) {
                foreach($cats as $cat) {
                    $option .= '<option value="'.$cat->id.'">'.$cat->name.'</option>';
                }
            }
        }
        return $option;
    }

}
