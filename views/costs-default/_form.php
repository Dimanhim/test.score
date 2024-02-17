<?php
use app\models\Categories;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]]]) ?>
<?= $form->field($model, 'name')->textInput() ?>
<?php if(Yii::$app->controller->action->id == 'add') { ?>
    <!--- категории -->
    <?php
    $items = ArrayHelper::map(Categories::getParentCats(0), 'id', 'name');
    $params = [
        'prompt' => 'Выбрать...'];
    ?>
    <div class="costs-category">
        <?= $form->field($model, 'category')->dropdownList($items, $params) ?>
    </div>
    <!--- подкатегории -->
    <?php
    $items = [];
    $params = [
        'prompt' => 'Выбрать...'];
    ?>
    <div class="costs-category auto-complete">
        <?= $form->field($model, 'category_child')->dropdownList($items, $params) ?>
    </div>
<?php } else { ?>
    <!--- категории -->
    <?php
    $items = [];
    foreach(Categories::find()->all() as $cat) {
        $items[$cat->id] = $cat->name;
    }
    $params = [
        'options' =>[
            $model->category => ['Selected' => true]
        ],
        'prompt' => 'Выбрать...'
    ];
    ?>
    <?= $form->field($model, 'category')->dropdownList($items, $params) ?>
<?php } ?>

<?= Html::submitButton('Добавить', ['class' => "btn btn-primary"]) ?>
<?php ActiveForm::end() ?>



