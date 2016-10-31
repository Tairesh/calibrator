<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = $model->text;

?>
<div class="question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'text:ntext',
            'answer',
            'source',
            'submitter.name',
            'dateSubmitted:date',
        ],
    ]) ?>

</div>
