<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\ContactForm;
use app\models\Categories;
use app\models\Scores;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;
use yii\widgets\LinkPager;

$this->title = 'Список доходов';
$count = 1;
$summ = 0
?>
<div class="scores">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <p class="bg-info" style="padding: 10px; border-radius: 5px"><?php echo Yii::$app->session->getFlash('success'); ?></p>
    <?php endif;?>
    <table class="table table-striped">
        <tr class="info">
            <th width="20">№</th>
            <th>Сумма</th>
            <th>Название</th>
            <th>Категория</th>
            <th>На счет</th>
            <th>Дата</th>
            <th>Действия</th>
        </tr>
        <?php foreach($model as $m) { ?>
            <tr>
                <td width="20"><?= $count ?></td>
                <td><b><?= $m->income ?></b></td>
                <td><?= $m->name ?></td>
                <td>
                    <a href="<?= Yii::$app->urlManager->createUrl(['cats/view', 'id' => $m->category]) ?>"><?= Categories::getCategoryName($m->category) ?></a>
                </td>

                <td><?= Scores::getScoreName($m->score) ?></td>
                <td><?= date('d-m-Y', $m->date) ?></td>
                <td>
                    <a href="<?= Yii::$app->urlManager->createUrl(['incomes/edit?id='.$m->id]) ?>"><span class="glyphicon glyphicon-edit"></span></a>
                    <a href="<?= Yii::$app->urlManager->createUrl(['incomes/delete?id='.$m->id]) ?>" class="delete"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
            <?php $summ = $summ + $m->income ?>
            <?php $count++ ?>
        <?php } ?>
        <tr style="font-weight: bold">
            <td>Итого:</td>
            <td><?= $summ ?></td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td><a href="<?= Yii::$app->urlManager->createUrl(['incomes/add']) ?>" class="btn btn-primary">Добавить доход</a></td>
            <td colspan="2"></td>
        </tr>
    </table>
    <?= LinkPager::widget(['pagination' => $pagination])  ?>
</div>





