<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invests';
$totalPrice = 0;
?>
<div class="invest-index">

    <div class="row">
        <div class="col-md-6">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered" style="margin-top: 30px;">
                <?php foreach($invest->invests as $key => $value) : ?>
                <tr>
                    <td>
                        <?= $value ?>
                    </td>
                    <td>
                        <?php
                            $investPrice = $invest->investPrice($key);
                            $totalPrice += $investPrice;
                            echo $investPrice;
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td>
                        Итого:
                    </td>
                    <td>
                        <?= $totalPrice ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'invest_id',
                'value' => function($data) {
                    return $data->investName;
                }
            ],
            'summ',
            [
                'attribute' => 'created_at',
                'value' => function($data) {
                    return $data->created_at ? date('d.m.Y', $data->created_at) : '';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
