<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\ContactForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'Счета';
?>
<div class="scores">
    <table class="table table-striped">
        <tr>
            <td>Название</td>
            <td><?= $model->name ?></td>
        </tr>
        <tr>
            <td>Описание</td>
            <td><?= $model->description ?></td>
        </tr>
        <tr>
            <td>Текущая сумма</td>
            <td><?= $model->summa ?> руб.</td>
        </tr>
        <tr>
            <td>По умолчанию</td>
            <td><?= $model->id_default ? Да : Нет ?></td>
        </tr>


        <tr>
            <td><a href="<?= Yii::$app->urlManager->createUrl(['scores/index']) ?>" class="btn btn-default">Вернуться к списку счетов</a></td>
            <td colspan="2"></td>
        </tr>
    </table>
</div>

