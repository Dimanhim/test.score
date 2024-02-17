<?php
$totalCount = 0;
$items = 0;
?>
<table class="table table-striped">
    <tr>
        <th>Дата</th>
        <th>Потрачено</th>
    </tr>
    <?php if($results) : ?>
        <?php foreach($results as $k => $v) : ?>
            <tr>
                <td><?= date('d.m.Y', $k) ?></td>
                <td><a href="<?= Yii::$app->urlManager->createUrl(['costs/each-day', 'date' => $k]) ?>"><?= $v ?></a></td>
            </tr>
        <?php $totalCount += $v; $items++ ?>
        <?php endforeach; ?>
        <tr>
            <td><b>Итого:</b></td>
            <td><?= $totalCount ?></td>
        </tr>
        <tr>
            <td><b>Среднее:</b></td>
            <td><?= round($totalCount / $days, 2) ?></td>
        </tr>
    <?php endif; ?>
</table>
