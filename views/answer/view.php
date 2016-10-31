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
        <?php if ($model->question->source): ?>
            <p><strong><?=Yii::t('app', 'Source')?>:</strong> <?=Html::a(Html::encode($model->question->source), $model->question->source)?></p>
        <?php endif ?>
        <h3><?=Yii::t('app', 'You answered')?>:</h3>
        <p class="<?=$model->isCorrect?'text-success':'text-danger'?>" ><strong><?=Yii::t('app', '90%')?>:</strong> <?=Yii::t('app', 'From {0} to {1}', [$model->ninetyStart, $model->ninetyEnd])?></p>
        <p class="<?=$model->isCorrect>1?'text-success':'text-danger'?>" ><strong><?=Yii::t('app', '50%')?>:</strong> <?=Yii::t('app', 'From {0} to {1}', [$model->fiftyStart, $model->fiftyEnd])?></p>
        <h2><?=Yii::t('app', 'Your score')?>: <label class="label <?=$model->score > 50 ? 'label-success' : 'label-warning'?>"><?=$model->score?></label></h2>
        <p class="help-block"><?=Yii::t('app', 'You are answered this question')?> <?=date('d-m-Y',$model->dateSubmitted)?></p>
        <p>
            <?=Html::a(Yii::t('app', 'Next question'), ['site/index'], ['class' => 'btn btn-lg btn-primary'])?>
        </p>
    </div>
</div>
