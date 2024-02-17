<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Invest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'invest_id')->dropDownList($model->invests, ['prompt' => '--Выбрать--']) ?>

    <?= $form->field($model, 'summ')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
