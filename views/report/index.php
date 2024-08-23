<?php

use yii\helpers\Url;

?>

<div class="report-page">

    <div class="report-flex">
        <div class="report-item">
            <a href="<?= Url::to(['report/incomes']) ?>">
                По доходам
            </a>
        </div>
        <div class="report-item">
            <a href="<?= Url::to(['report/cats']) ?>">
                По категориям
            </a>
        </div>
        <div class="report-item">
            <a href="">
                Отчет 3
            </a>
        </div>
        <div class="report-item">
            <a href="">
                Отчет 4
            </a>
        </div>
        <div class="report-item">
            <a href="">
                Отчет 5
            </a>
        </div>
    </div>

</div>

