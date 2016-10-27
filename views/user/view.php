<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name.' '.Yii::t('app', 'Brain Calibrator');

?>
<div class="user-view">

    <h1><?= Html::encode($model->name) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'score',
            'answersCount',
            'ninetyCount',
            'fiftyCount',
        ],
    ]) ?>

</div>
