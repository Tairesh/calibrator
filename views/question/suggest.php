<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = Yii::t('app', 'Suggest Question');

?>
<div class="question-create">

    <h1><?=Yii::t('app', 'Suggest Question')?></h1>

    <div class="question-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'text')->textarea(['rows' => 3]) ?>

        <?= $form->field($model, 'answer')->input('number') ?>

        <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
