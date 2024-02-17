<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
if($score->id_default == 1) $text = ['checked' => true];
if($score->is_check == 1) $text_2 = ['checked' => true];
?>
    <?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]]]) ?>
    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'summa')->textInput() ?>
    <?= $form->field($model, 'id_default')->checkbox() ?>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'is_check')->checkbox($text) ?>
<?= $form->field($model, 'credit_limit')->textInput() ?>
    <?= Html::submitButton('Сохранить', ['class' => "btn btn-primary"]) ?>
    <?php ActiveForm::end() ?>
