<?php

/* @var $this yii\web\View */

use app\models\Categories;
use app\models\Scores;
use app\models\Costs;
use app\models\Incomes;
use app\models\Settings;
use app\controllers\CostsController;

$this->title = 'Главная';
$settings = Settings::find()->one();
$checkForDays = $settings->month_limit;

$middleDefaultCosts = $checkForDays / Costs::getDaysForStatistycs();

$tomorrow = strtotime(date('d.m.Y')) + 86400;
$allCosts = Costs::getCosts(true);

$middleCosts = $allCosts / (($tomorrow - $settings->time_begin) / 86400);

$oneDayDiff = round($middleDefaultCosts - Costs::getDayCost());

if(($middleCosts - $middleDefaultCosts) > 0) {
    $infoResult = [
        'message' => 'Вы превышаете лимит на '.round($middleCosts - $middleDefaultCosts).' руб/день (дневной: '.$oneDayDiff.')',
        'payed_for_today' => $middleCosts,
        'remainder' => round($checkForDays - $allCosts),
        'class' => 'bg-danger',
    ];
} else {
    $infoResult = [
        'message' => 'Выше на '.round($middleDefaultCosts - $middleCosts).' руб/день (дневной: '.$oneDayDiff.')',
        'payed_for_today' => $middleCosts,
        'remainder' => round($checkForDays - $allCosts),
        'class' => 'bg-success',
    ];
}

?>
<div class="bg-block <?= $infoResult['class'] ?>">
    <div class="row">
        <div class="col-xs-8"><?= $infoResult['message'] ?></div>
        <div class="col-xs-4">осталось <?= $infoResult['remainder'] ?> руб.</div>
    </div>
    <?//= date('d.m.Y H:i', $tomorrow)  ?>
</div>
<table class="table">
    <tr>
        <td>Всего доступных средств</td>
        <td><b><?= Scores::getAccessMoney() ?></b></td>
    </tr>
    <?php foreach($scores as $score) { ?>
        <?php if(($score->is_check == 1) && ($score->id != 3)) { ?>
    <tr>
        <td><?= $score->name ?></td>
        <td><?= $score->summa ?> руб.</td>
    </tr>
        <?php } ?>
    <?php } ?>
</table>
<?php $set =  new \app\models\Settings() ?>
<h2>Расходы по категориям с <?= date('d-m-Y', $set->beginDate) ?> - <?= date('d-m-Y', $set->endDate) ?></h2>
<?php
$costs_count = 0;
$incomes_count = 0;
?>
<table class="table">
    <?php foreach($cats as $m) { ?>
        <?php if($m->parent == 0) { ?>
            <tr>
                <td>
                    <?php
                    if($m->source == Categories::INCOME) {
                        echo "<b>".$m->name."</b>";
                        $incomes_count += Incomes::getCatCosts($m->id);
                    }
                    else {
                        echo '<a href="'.Yii::$app->urlManager->createUrl(['costs/cat', 'id' => $m->id]).'">'.$m->name.'</a>';
                        $costs_count = Costs::getCatCosts($m->id);
                    }
                    ?>
                </td>
                <td>
                    <ul>
                        <?php foreach(Categories::getSubCats($m->id) as $v) { ?>
                            <li><a href="<?= Yii::$app->urlManager->createUrl(['costs/cat', 'id' => $v->id]) ?>"><?= $v->name ?> (<?= Costs::getCatCosts($v->id) ?> руб.)</a></li>
                        <?php } ?>
                    </ul>
                </td>
                <td>
                    <?php
                        if($m->source != Categories::INCOME) echo Costs::getCatCosts($m->id).' руб.';
                        else echo Incomes::getCatCosts($m->id).' руб.';
                    ?>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
</table>
<table class="table">
    <h3>Всего</h3>
    <tr>
        <th>Расходы</th>
        <th>Доходы</th>
    </tr>
    <tr>
        <td><?= Costs::getCosts() ?></td>
        <td><?= Incomes::getIncomesFull() ?></td>
    </tr>

</table>

