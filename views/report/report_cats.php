<?php

use kartik\date\DatePicker;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categories;
use kartik\select2\Select2;

$this->title = 'Расходы по категориям';

?>

<div class="report-cats">
    <h2><?= Html::encode($this->title) ?></h2>
    <div>
        <?php $form = ActiveForm::begin() ?>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'date_from')->widget(DatePicker::className(), []) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'date_to')->widget(DatePicker::className(), []) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'category_ids')->widget(Select2::className(), [
                    'data' => Categories::getList(),
                    'options' => [
                        'multiple' => true,
                    ],
                ]) ?>
            </div>
        </div>
        <?= Html::submitButton('Показать', ['class' => "btn btn-success"]) ?>
        <?php ActiveForm::end() ?>
    </div>
    <div>
        <?php
        echo Highcharts::widget([
            'options' => [
                'chart' => [
                    'type' => 'column',
                ],
                'title' => ['text' => $this->title],
                'xAxis' => [
                        // месяцы
                    'categories' => [1,2,3,4,5,6,7,8,9,1,2,3],
                ],
                'yAxis' => [
                    'title' => [
                        'text' => "Сумма",
                    ],
                ],
                'series' => $data
            ],
        ]);
        ?>
    </div>
</div>
