<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name.' '.Yii::t('app', 'Brain Calibrator');

?>
<div class="user-view">
    <div class="jumbotron">
        <h1><?=Html::img($model->photo, ['style' => 'border-radius:50px'])?> <?= Html::encode($model->name) ?></h1>
        <h2><?=$model->id == Yii::$app->user->id ? Yii::t('app', 'Your score') : Yii::t('app', 'Score')?>: <span class="label label-success"><?=$model->score?></span></h2>
        <br>
        <?php if ($model->answersCount > 0): ?>
        <?php
            $ninetyPercents = 100*$model->ninetyCount/$model->answersCount;
            $fiftyPercents = 100*$model->fiftyCount/$model->answersCount;
        ?>
        <p><?=Yii::t('app', 'Ninety Count')?>: <?=$model->ninetyCount?>/<?=(int)$model->answersCount?> <span class="label <?=($ninetyPercents > 70 && $ninetyPercents < 95)?'label-success':'label-warning'?>">(<?=number_format($ninetyPercents, 0, '', ' ')?>%)</span></p>
        <p class="help">
            <?php if ($ninetyPercents <= 70): ?>
            <span class="text-warning"><?=Yii::t('app', 'Ninety diapasons too small')?></span>
            <?php elseif ($ninetyPercents >= 95): ?>
            <span class="text-warning"><?=Yii::t('app', 'Ninety diapasons too big')?></span>
            <?php else: ?>
            <span class="text-success"><?=Yii::t('app', 'Ninety diapasons looking good')?></span>
            <?php endif ?>
        </p>
        <p><?=Yii::t('app', 'Fifty Count')?>: <?=$model->fiftyCount?>/<?=(int)$model->answersCount?> <span class="label <?=($fiftyPercents > 30 && $fiftyPercents < 70)?'label-success':'label-warning'?>">(<?=number_format(100*$model->fiftyCount/$model->answersCount, 0, '', ' ')?>%)</span></p>
        <p class="help">
            <?php if ($fiftyPercents <= 30): ?>
            <span class="text-warning"><?=Yii::t('app', 'Fifty diapasons too small')?></span>
            <?php elseif ($fiftyPercents >= 70): ?>
            <span class="text-warning"><?=Yii::t('app', 'Fifty diapasons too big')?></span>
            <?php else: ?>
            <span class="text-success"><?=Yii::t('app', 'Fifty diapasons looking good')?></span>
            <?php endif ?>
        </p>
        <?php endif ?>
    </div>        
    <?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'question.text',
                'label' => Yii::t('app', 'Question'),
                'value' => function($row) {
                    return Html::a($row['question']['text'], ['answer/view', 'id' => $row['id']]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'isCorrect',
                'value' => function($row) {
                    return Html::a([
                        0 => '<span class="label label-red">'.Yii::t('app', 'Incorrect').'</span>',
                        1 => '<span class="label label-danger">'.Yii::t('app', '90%').'</span>',
                        2 => '<span class="label label-success">'.Yii::t('app', '50%').'</span>',
                    ][(int)$row['isCorrect']], ['answer/view', 'id' => $row['id']]);
                },
                'format' => 'raw',
            ],
            'dateSubmitted:date',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
