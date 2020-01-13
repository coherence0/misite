<?php

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head> 
    <script src="https://api-maps.yandex.ru/2.1/?apikey=de65b2de-7b4c-4ae1-af27-4b3a8762b1e2&lang=ru_RU" type="text/javascript">
    </script>
    <script src="https://kit.fontawesome.com/5228d07c66.js" crossorigin="anonymous"></script>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header>
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="./images/logo.png"/><div style="padding-left: 10px"><div class="small-text-header">ФЕДЕРАЛЬНОЕ ГОСУДАРСТВЕННОЕ УНИТАРНОЕ ПРЕДПРИЯТИЕ</div><div class="text-header">
«Государственная корпорация по организации воздушного движения в Российской Федерации»</div></div>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-dark navbar-expand-lg nav-bar dark-blue'
        ],
    ]);

    NavBar::end();
    ?>
</header>

<div class="wrap">
        <?= $content ?>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
