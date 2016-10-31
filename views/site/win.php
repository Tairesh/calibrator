<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Game over') . ' ' . Yii::t('app', 'Brain Calibrator');

?>

<div class="site-index">
    <div class="jumbotron">
        <h1><?=Yii::t('app', 'Congratulations! Questions is over, you are answered it all!')?></h1>
        <br>
        <p><?=Yii::t('app', 'There`s no more questions for you.')?></p>
        <p><?=Yii::t('app', 'You can suggest your own question for others players and share this app to friends.')?></p>
        <br>
        <div class="form-group">
            <?=Html::a(Yii::t('app', 'Submit question'), ['question/suggest'], ['class' => 'btn btn-lg btn-primary'])?>
        </div>
    </div>
</div>