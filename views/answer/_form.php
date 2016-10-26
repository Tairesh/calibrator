<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userId')->textInput() ?>

    <?= $form->field($model, 'questionId')->textInput() ?>

    <?= $form->field($model, 'fiftyStart')->textInput() ?>

    <?= $form->field($model, 'fiftyEnd')->textInput() ?>

    <?= $form->field($model, 'ninetyStart')->textInput() ?>

    <?= $form->field($model, 'ninetyEnd')->textInput() ?>

    <?= $form->field($model, 'isCorrect')->textInput() ?>

    <?= $form->field($model, 'score')->textInput() ?>

    <?= $form->field($model, 'dateSubmitted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
