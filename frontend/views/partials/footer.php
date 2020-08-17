<?php

use yii\bootstrap\Html;

?>
<footer class="footer">
    <?php if (!Yii::$app->user->isGuest): ?>
        <input id="_access_token" type="hidden" value="<?= Yii::$app->user->identity->token ?>">
    <?php endif; ?>
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
    </div>
</footer>