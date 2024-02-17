<?php
$totalOnDays = 0;
$totalNotOnDays = 0;
$total = 0;
?>
<table class="table table-striped">
    <tr>
        <th>Наименование</th>
        <th>Потрачено</th>
        <th>Отображение по дням</th>
        <th>Редактировать</th>
    </tr>
    <?php if($costs) : ?>
        <?php foreach($costs as $cost) : ?>
            <tr>
                <td><?= $cost->name ?></td>
                <td>
                    <?php
                        echo $cost->cost;
                        $totalOnDays += $cost->check_for_days ? $cost->cost : 0;
                        $totalNotOnDays += $cost->check_for_days ? 0 : $cost->cost;
                    ?>
                </td>
                <td>
                    <?= $cost->check_for_days ? 'Да' : 'Нет' ?>
                </td>
                <td>
                    <a href="<?= Yii::$app->urlManager->createUrl(['costs/update', 'id' => $cost->id]) ?>">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td>
                <b>Итого по дням:</b>
            </td>
            <td>
                <b>
                    <?= $totalOnDays ?>
                </b>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <b>Итого без учета:</b>
            </td>
            <td>
                <b>
                    <?= $totalNotOnDays ?>
                </b>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <b>Итого:</b>
            </td>
            <td>
                <b>
                    <?= $totalOnDays + $totalNotOnDays ?>
                </b>
            </td>
            <td></td>
            <td></td>
        </tr>
    <?php endif; ?>
</table>
