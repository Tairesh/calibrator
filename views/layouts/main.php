<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);

if (Yii::$app->user->identity->role > 0) {
    $newQuestionsCount = app\models\Question::find()->where(['dateApproved' => NULL])->count();
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <div id="main-container" class="wrap">
    <?php
    if (!Yii::$app->user->isGuest) {
        NavBar::begin([
            'brandLabel' => Html::img(Yii::$app->user->identity->photo) . Yii::$app->user->identity->name,
            'brandUrl' => ['/user/view', 'id' => Yii::$app->user->id],
            'options' => [
                'class' => 'navbar navbar-default navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => array_merge([            
                ['label' => Yii::t('app', 'Answer a question'), 'url' => ['/site/index']],
                ['label' => Yii::t('app', 'Users rating'), 'url' => ['/user/index', 'sort' => '-score']],
                ['label' => Yii::t('app', 'Submit question'), 'url' => ['/question/suggest']],
            ], Yii::$app->user->identity->role > 0 ? [
                ['label' => Yii::t('app', 'New questions') . " ({$newQuestionsCount})", 'url' => ['/question/new']],
            ] : []),
        ]);
        NavBar::end();
    }
    ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
