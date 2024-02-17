<?php

/* @var $this yii\web\View */

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="container page-reg page-two">
    <h2>Регистрация</h2>
    <?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]], 'options' => ['class' => 'form-reg']]) ?>
    <?= $form->field($model, 'username')->textInput(['placeholder' => "login", "required" => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => "********", "required" => true]) ?>
    <?= $form->field($model, 'password_2')->passwordInput(['placeholder' => "********", "required" => true]) ?>
    <?= Html::submitButton('Зарегистрироваться', ['class' => "btn main-bt"]) ?>
    <?php ActiveForm::end() ?>
</div>
