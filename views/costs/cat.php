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

$this->title = 'Расходы по категории';
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
            <th>Со счета</th>
            <th>Дата</th>
        </tr>
        <?php foreach($model as $m) { ?>
            <tr>
                <td width="20"><?= $count ?></td>
                <td><b><?= $m->cost ?></b></td>
                <td><?= $m->name ?></td>
                <td><?= Scores::getScoreName($m->score) ?></td>
                <td><?= date('d-m-Y', $m->date) ?></td>
            </tr>
            <?php $summ = $summ + $m->cost ?>
            <?php $count++ ?>
        <?php } ?>
        <tr style="font-weight: bold">
            <td>Итого:</td>
            <td><?= $summ ?></td>
            <td colspan="4"></td>
        </tr>
    </table>
    <?= LinkPager::widget(['pagination' => $pagination])  ?>
</div>





