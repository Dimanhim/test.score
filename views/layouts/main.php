<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$activePage = Yii::$app->controller->id;
$activeAction = Yii::$app->controller->action->id;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a class="pull-right" href="/site/logout">Выйти</a>
                </div>
                <div class="col-md-3">
                    <ul class="nav">
                        <li><a href="<?= Yii::$app->urlManager->createUrl(['costs/add']) ?>" class="btn btn-success add-score">Добавить расход</a></li>
                        <li><a href="<?= Yii::$app->urlManager->createUrl(['incomes/add']) ?>" class="btn btn-primary">Добавить Доход</a></li>
                        <li<?php if($activePage == 'cats') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['cats/index']) ?>">Категории</a></li>
                        <li<?php if($activePage == 'report') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['report/index']) ?>">Статистика</a></li>
                        <li<?php if($activePage == 'costs-default') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['costs-default/index']) ?>">Расходы по умолчанию</a></li>
                        <li<?php if($activePage == 'incomes-default') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['incomes-default/index']) ?>">Доходы по умолчанию</a></li>
                        <li<?php if($activePage == 'payments') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['payments/index']) ?>">Обязательные платежи</a></li>
                        <li<?php if($activePage == 'payments') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['save/index']) ?>">Копилка</a></li>
                        <li<?php if($activePage == 'settings') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['settings/index']) ?>">Настройки</a></li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <ul class="nav nav-tabs">
                        <li<?php if($activePage == 'site') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>">Главная</a></li>
                        <li<?php if($activePage == 'scores') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['scores/index']) ?>">Мои счета</a></li>

                        <li<?php if(($activePage == 'costs') && ($activeAction == 'index')) { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['costs/index']) ?>">Расходы</a></li>
                        <li<?php if($activePage == 'incomes') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['incomes/index']) ?>">Доходы</a></li>

                        <li<?php if($activePage == 'transfer') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['transfer/add']) ?>">Переводы</a></li>
                        <li<?php if(($activePage == 'costs') && ($activeAction == 'days')) { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['costs/days']) ?>">По дням</a></li>
                        <!--
                        <li<?php //if($activePage == 'invest') { ?> class="active"<?php //} ?>><a href="<?//= Yii::$app->urlManager->createUrl(['invest/index']) ?>">Invest</a></li>
                        -->
                        <li<?php if($activePage == 'log') { ?> class="active"<?php } ?>><a href="<?= Yii::$app->urlManager->createUrl(['log/index']) ?>">Логи</a></li>
                    </ul>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>

            </div>


    </div>
</div>

<footer class="footer">
    <div class="container">

    </div>
</footer>

<?php $this->endBody() ?>
<script>
    $('.delete').on('click', function() {
        if(!confirm("Вы уверены, что хотите удалить действие?")) return false;
    });
</script>
</body>
</html>
<?php $this->endPage() ?>
