<?php
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
?>
<h2>Показывать информацию</h2>
<?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]]]) ?>

<!--- Дата от -->
<?= $form->field($model, 'time_begin')->widget(DatePicker::className(), [
    'options' => [
        'value' => $model->time_begin ? date('d-m-Y', $model->time_begin) : date('d-m-Y'),
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-mm-yyyy',
        'todayHighlight' => true,
    ]
]);
?>
<!--- Дата до -->
<?= $form->field($model, 'time_end')->widget(DatePicker::className(), [
    'options' => [
        'value' => $model->time_end ? date('d-m-Y', $model->time_end) : date('d-m-Y'),
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-mm-yyyy',
        'todayHighlight' => true,
    ]
]);
?>
<?= $form->field($model, 'month_limit')->textInput() ?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'notes_1')->textarea(['cols' => 10, 'rows' => 10]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'notes_2')->textarea(['cols' => 10, 'rows' => 10]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'notes_3')->textarea(['cols' => 10, 'rows' => 10]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'notes_4')->textarea(['cols' => 10, 'rows' => 10]) ?>
    </div>
</div>

<?= Html::submitButton('Сохранить', ['class' => "btn btn-primary"]) ?>
<?php ActiveForm::end() ?>
