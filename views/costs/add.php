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
use \yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

$this->title = 'Добавление расхода';
?>
<div class="col-md-6 col-md-offset-3" style="height: 40px; margin-top: 10px">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <p class="bg-info" style="padding: 10px; border-radius: 5px"><?php echo Yii::$app->session->getFlash('success'); ?></p>
    <?php endif;?>
</div>

<div class="col-md-6 col-md-offset-3">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>



