<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\Categories;
use app\models\Incomes;
use app\models\Scores;
use yii\grid\GridView;

$this->title = 'Список доходов';
$count = 1;
$summ = 0
?>
<div class="scores">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'pager' => [
            'options' => ['class' => 'pagination inline'],
        ],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'income',
                'value' => function($data) {
                    return $data->income;
                },
                //'footer' => Yii::$app->formatter->asDecimal(Incomes::getTotal($dataProvider->models, 'income')),
                'footer' => '<b>'.Yii::$app->formatter->asHtml(Incomes::getTotal($dataProvider->models, 'income')).'</b>',
            ],
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
            'date:date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttonOptions' => ['class' => 'action-btn action-btn-2x'],
            ],
        ],
    ]); ?>
</div>




