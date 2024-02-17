<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Invest */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="invest-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'invest_id',
                'value' => function($data) {
                    return $data->investName;
                }
            ],
            'summ',
            [
                'attribute' => 'created_at',
                'value' => function($data) {
                    return $data->created_at ? date('d.m.Y', $data->created_at) : '';
                }
            ],
        ],
    ]) ?>

</div>
