<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Brain Calibrator');

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>
        <?php if (Yii::$app->user->isGuest): ?>
        <p>
            <?=Html::a(Yii::t('app','Login with VK'), ['site/auth', 'authclient' => 'vkontakte'], ['class' => 'btn btn-lg btn-primary'])?>
        </p>
        <?php endif ?>
        <?php        var_dump(\app\models\Account::find()->all(), \app\models\User::find()->all()); ?>
    </div>

</div>
