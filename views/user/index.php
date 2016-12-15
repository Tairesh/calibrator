<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users').' '.Yii::t('app', 'Brain Calibrator');

?>
<div class="user-index">
    <?php Pjax::begin(); ?>   
    <h1><?=Yii::t('app', 'Users rating')?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => function ($row) {
                    return Html::a(Html::img($row['photo'], ['style' => 'width:16px']), ['user/view', 'id' => $row['id']]).' '.Html::a($row['name'], ['user/view', 'id' => $row['id']]);
                },
                'format' => 'raw',
            ],
            'score',
            'answersCount:integer',
            [
                'attribute' => 'ninetyPercent',
                'value' => function ($row) {
                    return $row['ninetyPercent'].'%';
                },
            ],
            [
                'attribute' => 'fiftyPercent',
                'value' => function ($row) {
                    return $row['fiftyPercent'].'%';
                },
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
