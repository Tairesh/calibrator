<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name.' '.Yii::t('app', 'Brain Calibrator');

?>
<div class="user-view">
    <div class="jumbotron">
        <h1><?= Html::encode($model->name) ?></h1>
        <h2><?=$model->id == Yii::$app->user->id ? Yii::t('app', 'Your score') : Yii::t('app', 'Score')?>: <span class="label label-success"><?=$model->score?></span></h2>
        <?php if ($model->answersCount > 0): ?>
        <?php
            $ninetyPercents = 100*$model->ninetyCount/$model->answersCount;
            $fiftyPercents = 100*$model->fiftyCount/$model->answersCount;
        ?>
        <p><?=Yii::t('app', 'Ninety rating')?>: <?=$model->ninetyCount?>/<?=$model->answersCount?> <span class="label <?=($ninetyPercents > 70 && $ninetyPercents < 95)?'label-success':'label-warning'?>">(<?=number_format($ninetyPercents, 0, '', ' ')?>)</span></p>
        <p><?=Yii::t('app', 'Fifty rating')?>: <?=$model->fiftyCount?>/<?=$model->answersCount?> <span class="label <?=($fiftyPercents > 30 && $fiftyPercents < 70)?'label-success':'label-warning'?>">(<?=number_format(100*$model->fiftyCount/$model->answersCount, 0, '', ' ')?>)</span></p>
        <?php endif ?>
    </div>
</div>
