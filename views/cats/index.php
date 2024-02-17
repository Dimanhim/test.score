<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\models\ContactForm;
use app\models\Categories;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'Категории';
$count = 1;
?>
<div class="scores">
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <p class="bg-info" style="padding: 10px; border-radius: 5px"><?php echo Yii::$app->session->getFlash('success'); ?></p>
    <?php endif;?>
    <table class="table table-striped">
        <tr class="info">
            <th>№</th>
            <th>Название</th>
            <th>Дочерние</th>
            <th>Описание</th>
            <th>Показывать</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
        <?php foreach($model as $m) { ?>
            <?php if($m->parent == 0) { ?>
            <tr>
                <td width="20"><?= $count ?></td>
                <td>
                    <?php
                        if($m->source == Categories::INCOME) echo "<b>".$m->name."</b>";
                        else echo $m->name;
                    ?>
                </td>
                <td>
                    <ul>
                    <?php foreach(Categories::getSubCats($m->id) as $v) { ?>
                        <li><a href="<?= Yii::$app->urlManager->createUrl(['cats/view', 'id' => $v->id]) ?>"><?= $v->name ?></a></li>
                    <?php } ?>
                    </ul>
                </td>
                <td><?= $m->description ?></td>
                <td><?= $m->show_default ? 'Да' : 'Нет' ?></td>

                <td><?= date('d-m-Y', $m->date) ?></td>
                <td>
                    <a href="<?= Yii::$app->urlManager->createUrl(['cats/view?id='.$m->id]) ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                    <a href="<?= Yii::$app->urlManager->createUrl(['cats/edit?id='.$m->id]) ?>"><span class="glyphicon glyphicon-edit"></span></a>
                    <a href="<?= Yii::$app->urlManager->createUrl(['cats/delete?id='.$m->id]) ?>" class="delete"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
            <?php $count++ ?>
            <?php } ?>
        <?php } ?>
        <tr>
            <td><a href="<?= Yii::$app->urlManager->createUrl(['cats/add']) ?>" class="btn btn-primary">Добавить категорию</a></td>
            <td colspan="5"></td>
        </tr>
    </table>
</div>



