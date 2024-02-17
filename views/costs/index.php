<?php

use app\models\Categories;
use app\models\Scores;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Расходы';
?>

<div class="scores">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'options' => ['class' => 'pagination inline'],
        ],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'cost',
            'name',
            [
                'attribute' => 'category',
                'value' => function($data) {
                    return Categories::getCategoryName($data->category);
                }
            ],
            [
                'attribute' => 'score',
                'value' => function($data) {
                    return Scores::getScoreName($data->score);
                }
            ],
            [
                'attribute' => 'date',
                'value' => function($data) {
                    return date('d.m.Y', $data->date);
                }
            ],
            /*[
                'attribute' => 'date_begin',
                'value' => function($data) {
                    return $data->date_begin ? date('d.m.Y', $data->date_begin) : '---';
                }
            ],
            [
                'attribute' => 'date_end',
                'value' => function($data) {
                    return $data->date_end ? date('d.m.Y', $data->date_end) : '---';
                }
            ],
            'price',*/
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttonOptions' => ['class' => 'action-btn action-btn-2x'],
            ],
        ],
    ]); ?>
</div>