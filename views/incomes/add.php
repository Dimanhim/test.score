<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\ContactForm;
use app\models\Categories;
use app\models\Scores;
use app\models\CostsDefault;
use app\models\IncomesDefault;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'Добавление дохода';
$text = [];
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
        foreach(IncomesDefault::find()->all() as $def) {
            $items[$def->id] = $def->name;
        }
        $params = [
            'prompt' => 'Выбрать...',
        ];
        ?>
        <?= $form->field($model, 'income_default')->dropdownList($items, $params) ?>
    </div>

    <div class="costs-name">
        <?= $form->field($model, 'name')->textInput() ?>
    </div>
    <?php
    $items = [];
    foreach(Categories::find()->where(['source' => 1])->all() as $cat) {
        $items[$cat->id] = $cat->name;
    }
    $params = [
        'prompt' => 'Выбрать...'];
    ?>
    <div class="costs-category">
        <?= $form->field($model, 'category')->dropdownList($items, $params) ?>
    </div>
    <?= $form->field($model, 'income')->textInput(['type' => 'number']) ?>
    <?php
    $items = [];
    foreach(Scores::find()->all() as $score) {
        $items[$score->id] = $score->name;
    }
    $params = [
        $score->id_default => ['Selected' => true]
    ];
    ?>
    <?= $form->field($model, 'score')->dropdownList($items, $params) ?>
    <?= Html::submitButton('Добавить', ['class' => "btn btn-primary"]) ?>
    <?php ActiveForm::end() ?>
</div>



