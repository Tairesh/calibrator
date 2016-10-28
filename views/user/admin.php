<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users').' '.Yii::t('app', 'Brain Calibrator');

?>
<div class="user-admin">

    <h1><?=Yii::t('app', 'Users rating')?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => function ($row) {
                    return Html::a($row['name'], ['user/view', 'id' => $row['id']]);
                },
                'format' => 'raw',
            ],
            'score',
            'answersCount:integer',
            [
                'attribute' => 'ninetyCount',
                'value' => function ($row) {
                    return ($row['answersCount'] > 0 ? number_format(100*$row['ninetyCount']/$row['answersCount'],0) : 0).'%';
                },
            ],
            [
                'attribute' => 'fiftyCount',
                'value' => function ($row) {
                    return ($row['answersCount'] > 0 ? number_format(100*$row['fiftyCount']/$row['answersCount'],0) : 0).'%';
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
