<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\ContactForm;
use app\models\Categories;
use app\models\CostsDefault;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'Расходы по умолчанию';
?>
<div class="scores">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <p class="bg-info" style="padding: 10px; border-radius: 5px"><?php echo Yii::$app->session->getFlash('success'); ?></p>
    <?php endif;?>
    <table class="table table-striped">
        <tr class="info">
            <th width="20">№</th>
            <th>Название</th>
            <th>Категория</th>
            <th>Действия</th>
        </tr>
        <?php foreach($model as $m) { ?>
            <tr>
                <td width="20"><?= $count ?></td>
                <td><?= $m->name ?></td>
                <td>
                    <a href="<?= Yii::$app->urlManager->createUrl(['cats/view', 'id' => $m->category]) ?>"><?= Categories::getCategoryName($m->category) ?></a>
                </td>
                <td>
                    <a href="<?= Yii::$app->urlManager->createUrl(['costs-default/edit?id='.$m->id]) ?>"><span class="glyphicon glyphicon-edit"></span></a>
                    <a href="<?= Yii::$app->urlManager->createUrl(['costs-default/delete?id='.$m->id]) ?>" class="delete"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
            <?php $count++ ?>
        <?php } ?>
        <tr>
            <td><a href="<?= Yii::$app->urlManager->createUrl(['costs-default/add']) ?>" class="btn btn-primary">Добавить расход по умолчанию</a></td>
            <td colspan="2"></td>
        </tr>
    </table>
</div>





