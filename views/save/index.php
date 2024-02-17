<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Копилка';
$totalSumm = 0;
?>
<div class="scores">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <p class="bg-info" style="padding: 10px; border-radius: 5px"><?php echo Yii::$app->session->getFlash('success'); ?></p>
    <?php endif;?>
    <table class="table table-striped">
        <tr class="info">
            <th>Название</th>
            <th>Сумма</th>
            <th>Действие</th>
        </tr>
        <?php foreach($scores as $score) { ?>
        <tr>
            <td><?= $score->name ?></td>
            <td><?= $score->summa ?> руб.</td>
            <td>
                <a href="<?= Yii::$app->urlManager->createUrl(['save/view?id='.$score->id]) ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                <a href="<?= Yii::$app->urlManager->createUrl(['save/edit?id='.$score->id]) ?>"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="<?= Yii::$app->urlManager->createUrl(['save/delete?id='.$score->id]) ?>" class="delete"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
        </tr>
            <?php $totalSumm += $score->summa ?>
        <?php } ?>
        <tr>
            <td>
                <b>Итого:</b>
            </td>
            <td>
                <b><?= $totalSumm ?> руб.</b>
            </td>
            <td></td>
        </tr>
        <tr>
            <td><a href="<?= Yii::$app->urlManager->createUrl(['save/add']) ?>" class="btn btn-primary">Добавить накопление</a></td>
            <td colspan="2"></td>
        </tr>
    </table>
</div>

