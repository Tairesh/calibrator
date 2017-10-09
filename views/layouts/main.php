<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);

if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role > 0) {
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
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-32774277-1', 'auto');
ga('send', 'pageview');
    </script>
    <!-- Yandex.Metrika counter -->
    <script>
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter45932511 = new Ya.Metrika({
                    id:45932511,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/45932511" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

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
