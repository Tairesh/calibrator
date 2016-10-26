<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */

$this->title = $model->question->text.' '.Yii::t('app', 'Brain Calibrator');

?>
<div class="answer-view">
    <div class="jumbotron">
        <h2><?=Html::encode($model->question->text) ?></h2>
        <h1><?=number_format($model->question->answer,0,'.',' ')?></h1>
        <h3><?=Yii::t('app', 'You answered')?>:</h3>
        <p class="<?=$model->isCorrect?'text-success':''?>" ><strong><?=Yii::t('app', '90%')?>:</strong> From <?=$model->ninetyStart?> to <?=$model->ninetyEnd?></p>
        <p class="<?=$model->isCorrect>1?'text-success':''?>" ><strong><?=Yii::t('app', '50%')?>:</strong> From <?=$model->fiftyStart?> to <?=$model->fiftyEnd?></p>
        <h2><?=Yii::t('app', 'Your score')?>: <label class="label label-success"><?=$model->score?></label></h2>
        <p class="help-block"><?=Yii::t('app', 'You are answered this question')?> <?=date('d-m-Y',$model->dateSubmitted)?></p>
        <p>
            <?=Html::a(Yii::t('app', 'Next question'), ['site/index'], ['class' => 'btn btn-lg btn-primary'])?>
        </p>
    </div>
</div>
