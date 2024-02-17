<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Счета';
$totalSumm = 0;
$totalSummNal = 0;
?>
<div class="scores">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <p class="bg-info" style="padding: 10px; border-radius: 5px"><?php echo Yii::$app->session->getFlash('success'); ?></p>
    <?php endif;?>
    <table class="table table-striped">
        <tr class="info">
            <th>Название</th>
            <th>Текущая сумма</th>
            <th>По умолчанию</th>
            <th>Кредитный лимит</th>
            <th>Действие</th>
        </tr>
        <?php foreach($scores as $score) { ?>
        <tr>
            <td><?= $score->name ?></td>
            <td>
                <?php
                    if(!$score->credit_limit) {
                        if($score->id != 19) {
                            $totalSummNal += $score->summa;
                            $totalSumm += $score->summa;
                        }

                    } else {
                        $totalSumm += $score->summa - $score->credit_limit;
                    }
                ?>
                <?= $score->summa ?> руб.
            </td>
            <td><?= $score->id_default ? 'Да' : 'Нет' ?></td>
            <td><?= $score->credit_limit ?></td>
            <td>
                <a href="<?= Yii::$app->urlManager->createUrl(['scores/view?id='.$score->id]) ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                <a href="<?= Yii::$app->urlManager->createUrl(['scores/edit?id='.$score->id]) ?>"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="<?= Yii::$app->urlManager->createUrl(['scores/delete?id='.$score->id]) ?>" class="delete"><span class="glyphicon glyphicon-remove"></span></a>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td>
                <b>Итого:</b>
            </td>
            <td>
                <b><?= $totalSumm ?></b>
            </td>
            <td colspan="3">
                <i>За вычетом кредитных карт и Текущего счета ВТБ</i>
            </td>
        </tr>
        <tr>
            <td>
                <b>Итого имеется:</b>
            </td>
            <td>
                <b><?= $totalSummNal ?></b>
            </td>
            <td colspan="3">
                <i>За вычетом Текущего счета ВТБ</i>
            </td>
        </tr>
        <tr>
            <td><a href="<?= Yii::$app->urlManager->createUrl(['scores/add']) ?>" class="btn btn-primary">Добавить счет</a></td>
            <td colspan="2"></td>
        </tr>
    </table>
</div>

