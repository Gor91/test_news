<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;

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
    <?= $this->render('/partials/header-nav') ?>

    <div class="container">
        <?= Alert::widget() ?>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= $this->render('/partials/left-nav') ?>
        <?php endif; ?>
        <!-- main area -->
        <div class="col-xs-12 col-sm-9">
            <?= $content ?>
        </div>
    </div>
</div>
<?= $this->render('/partials/footer') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
