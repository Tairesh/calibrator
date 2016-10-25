<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Login') . ' ' . Yii::t('app', 'Brain Calibrator');

?>
<div class="site-index">
    <div class="jumbotron">
        <p>
            <?=Html::a(Yii::t('app','Login with VK'), ['site/auth', 'authclient' => 'vkontakte'], ['class' => 'btn btn-lg btn-primary'])?>
        </p>
    </div>
</div>