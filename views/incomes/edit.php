<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\Categories;
use app\models\ContactForm;
use app\models\Scores;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'Редактирование дохода';
?>
<div class="col-md-6 col-md-offset-3" style="height: 40px; margin-top: 10px">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <p class="bg-info" style="padding: 10px; border-radius: 5px"><?php echo Yii::$app->session->getFlash('success'); ?></p>
    <?php endif;?>
</div>

<div class="col-md-6 col-md-offset-3">
    <?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]]]) ?>
    <?= $form->field($model, 'name')->textInput(['value' => $costs->name]) ?>
    <?php
    $items = [];
    foreach(Categories::find()->all() as $cat) {
        $items[$cat->id] = $cat->name;
    }
    $params = [
        'options' =>[
            $model->category => ['Selected' => true]
        ],
        'prompt' => 'Выбрать...'
    ];
    ?>

    <?= $form->field($model, 'category')->dropdownList($items, $params) ?>
    <?= $form->field($model, 'income')->textInput(['value' => $costs->income, 'type' => 'number']) ?>

    <?php
    $items = [];
    foreach(Scores::find()->all() as $score) {
        $items[$score->id] = $score->name;
    }
    $params = [
        'options' =>[
            $costs->score => ['Selected' => true],
        ],
        'prompt' => 'Выбрать...',
    ];
    ?>
    <?= $form->field($model, 'score')->dropdownList($items, $params) ?>

    <?= Html::submitButton('Сохранить', ['class' => "btn btn-primary"]) ?>

    <br />
    <?= Html::a('Вернуться к списку доходов', Yii::$app->urlManager->createUrl(['incomes/index']), ['class' => "btn btn-default", 'style' => 'margin-top: 10px']) ?>
    <?php ActiveForm::end() ?>
</div>




