<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'New questions');

?>
<div class="question-new">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'text:ntext',
            'answer',
            'source:url',
            'submitter.name',
            'dateSubmitted:date',
            [
                'value' => function($row) {
                    return 
                        Html::a(Yii::t('app', 'Approve'), ['question/approve', 'id' => $row['id']], ['class' => 'btn btn-xs btn-success']) . 
                        Html::a(Yii::t('app', 'Edit'), ['question/update', 'id' => $row['id']], ['class' => 'btn btn-xs btn-primary']) . 
                        Html::a(Yii::t('app', 'Delete'), ['question/delete', 'id' => $row['id']], ['class' => 'btn btn-xs btn-danger', 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'), 'data-method' => 'post']);
                },
                'format' => 'raw',
                'options' => ['style' => 'width: 152px;'],
            ],
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
