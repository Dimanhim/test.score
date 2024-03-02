<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Log;
use app\models\Scores;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'type_id',
                'value' => function($data) {
                    return $data->typeName;
                },
                'filter' => Log::getTypes(),
            ],
            'value',
            'name',
            'desc',
            [
                'attribute' => 'score_id',
                'value' => function($data) {
                    if($data->score) {
                        return $data->score->name;
                    }
                },
                'filter' => Scores::getList(),
            ],
            [
                'attribute' => 'created_at',
                'value' => function($data) {
                    if($data->created_at) {
                        return date('d.m.Y H:i', $data->created_at);
                    }
                },
                'filter' => DatePicker::widget([
                    'attribute' => 'created_at',
                    'model' => $searchModel
                ]),
            ],
        ],
    ]); ?>


</div>
