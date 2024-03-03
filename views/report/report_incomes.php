<?php

use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

$this->title = 'Статистика доходов';

?>

<div class="report-incomes">
    <h2><?= Html::encode($this->title) ?></h2>
    <div>
        <?php $form = ActiveForm::begin(['id' => 'form-report-incomes']) ?>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'date_from')->widget(DatePicker::className(), [

                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'date_to')->widget(DatePicker::className(), [

                ]) ?>
            </div>
        </div>

        <?= Html::submitButton('Показать', ['class' => "btn"]) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div>
        <?php
        echo Highcharts::widget([
                'options' => [
                        'title' => ['text' => $this->title],
                    'xAxis' => [
                        'categories' => $dates,
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' => "Сумма",
                        ],
                    ],
                    'series' => [
                        //['name' => 'Доход', 'data' => [1,2,3]]
                        ['name' => 'Общий без пенсии', 'data' => $values],
                        ['name' => 'Зарплата', 'data' => $salary],
                        ['name' => 'Пенсия', 'data' => $pension]
                    ],
                ],
        ]);
        ?>
    </div>
</div>
