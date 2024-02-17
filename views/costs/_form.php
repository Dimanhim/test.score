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
    use app\models\Payments;
?>
<?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]]]) ?>
<!-- по умолчанию -->
    <div class="changeble-default">
        <?php
        $items = [];
        foreach(CostsDefault::find()->all() as $def) {
            $items[$def->id] = $def->name;
        }
        $params = [
            'prompt' => 'Выбрать...'];
        ?>
        <?= $form->field($model, 'costs_default')->dropdownList($items, $params) ?>
    </div>
<!-- название -->
    <div class="costs-name">
        <?= $form->field($model, 'name')->textInput() ?>
    </div>

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

<!--- сумма -->
    <?= $form->field($model, 'cost')->textInput(['type' => 'number']) ?>
<!--- списать со счета -->
    <?php
    $items = [];
    foreach(Scores::find()->orderBy('id_default DESC')->all() as $score) {
        $items[$score->id] = $score->name;
    }
    $params = [
        $score->id_default => ['Selected' => true]
    ];
    ?>
    <?= $form->field($model, 'score')->dropdownList($items, $params) ?>
<!--- Дата -->
    <?= $form->field($model, 'date')->widget(DatePicker::className(), [
            'options' => [
                'value' => $model->date ? date('d-m-Y', $model->date) : date('d-m-Y'),
            ],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true,
            ]
        ]);
    ?>

    <?= $form->field($model, 'check_for_days')->checkbox() ?>
    <div id="obligstory_payments">
        <?= $form->field($model, 'obligstory_payments')->dropDownList(ArrayHelper::map(Payments::find()->all(), 'id', 'name'), ['prompt' => '--Выбрать--']) ?>
    </div>

    <?= Html::submitButton('Сохранить', ['class' => "btn btn-primary"]) ?>
    <?php ActiveForm::end() ?>
