<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Invest */

$this->title = 'Редактировать Invest: ' . $model->id;
?>
<div class="invest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
