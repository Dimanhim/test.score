<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\ContactForm;
use app\models\Categories;
use app\models\Scores;
use app\models\CostsDefault;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'Переводы между счетами';
?>
<div class="col-md-6 col-md-offset-3" style="height: 40px; margin-top: 10px">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <p class="bg-info" style="padding: 10px; border-radius: 5px"><?php echo Yii::$app->session->getFlash('success'); ?></p>
    <?php endif;?>
</div>

<div class="col-md-6 col-md-offset-3">
    <?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]]]) ?>
    <div class="changeble-default">
        <?php
        $items = [];
        foreach(Scores::find()->all() as $item) {
            $items[$item->id] = $item->name . ' (' . $item->summa . ' р.)';
        }
        $params = [
            'prompt' => 'Выбрать...'];
        ?>
        <?= $form->field($model, 'transfer_out')->dropdownList($items, $params) ?>

        <?php
        $items = [];
        foreach(Scores::find()->all() as $item) {
            $items[$item->id] = $item->name . ' (' . $item->summa . ' р.)';
        }
        $params = [
            'prompt' => 'Выбрать...'];
        ?>
        <?= $form->field($model, 'transfer_in')->dropdownList($items, $params) ?>
        <?= $form->field($model, 'summa')->textInput(['placeholder' => 'Введите сумму', 'type' => 'number']) ?>

    </div>

    <?= Html::submitButton('Перевести', ['class' => "btn btn-primary"]) ?>
    <?php ActiveForm::end() ?>
</div>



