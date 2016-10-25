<?php

/* @var $this yii\web\View */
/* @var $question app\models\Question */
/* @var $answer app\models\Answer */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Brain Calibrator');

?>
<div class="site-index">

    <div class="jumbotron">
        <?php if (Yii::$app->user->isGuest): ?>
        <p>
            <?=Html::a(Yii::t('app','Login with VK'), ['site/auth', 'authclient' => 'vkontakte'], ['class' => 'btn btn-lg btn-primary'])?>
        </p>
        <?php else: ?>
        
        <h1><?=$question->text?></h1>
        <div class="row" style="margin-top: 3em">     
            <?php $form = ActiveForm::begin([
                'id' => 'answer-form',
                'options' => ['class' => 'form-inline'],
                'fieldConfig' => [
                    'template' => "{input}",
                ],
                'enableAjaxValidation' => true
            ]); ?>
            <div class="form-group">
                <label for="exampleInputAmount"><?=Yii::t('app', '90%')?></label>
                <div class="input-group">
                    <div class="input-group-addon"><?=Yii::t('app', 'From')?></div>
                    <?=$form->field($answer, 'ninetyStart')->textInput()?>
                </div>
                <div class="input-group">
                    <div class="input-group-addon"><?=Yii::t('app', 'To')?></div>
                    <?=$form->field($answer, 'ninetyEnd')->textInput()?>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputAmount"><?=Yii::t('app', '50%')?></label>
                <div class="input-group">
                    <div class="input-group-addon"><?=Yii::t('app', 'From')?></div>
                    <?=$form->field($answer, 'fiftyStart')->textInput()?>
                </div>
                <div class="input-group">
                    <div class="input-group-addon"><?=Yii::t('app', 'To')?></div>
                    <?=$form->field($answer, 'fiftyEnd')->textInput()?>
                </div>
            </div>
            <div class="form-group" style="margin: 3em 0; display: block">
                <?=$form->errorSummary($answer)?>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <?=$form->field($answer, 'questionId')->hiddenInput()?>
                    <?= Html::submitButton(Yii::t('app', 'Send answer'), ['class' => 'btn btn-lg btn-primary', 'name' => 'submit-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <?php endif ?>
    </div>
</div>
<?php var_dump(\app\models\Answer::find()->all()) ?>
