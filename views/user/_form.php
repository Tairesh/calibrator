<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList([
        User::GENDER_UNKNOWN => Yii::t('app', 'Unknown gender'),
        User::GENDER_FEMALE => Yii::t('app', 'Female'),
        User::GENDER_MALE => Yii::t('app', 'Male'),
    ]) ?>

    <?= $form->field($model, 'score')->input('number') ?>

    <?= $form->field($model, 'answersCount')->input('number') ?>

    <?= $form->field($model, 'ninetyCount')->input('number') ?>

    <?= $form->field($model, 'fiftyCount')->input('number') ?>

    <?= $form->field($model, 'role')->dropDownList([
        User::ROLE_USER => Yii::t('app', 'User'),
        User::ROLE_MODERATOR => Yii::t('app', 'Moderator'),
        User::ROLE_ADMIN => Yii::t('app', 'Administrator'),
    ]) ?>

    <?= $form->field($model, 'questionsCount')->input('number') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
