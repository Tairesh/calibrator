<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\authclient\AuthAction;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use app\models\Account;
use app\models\Question;
use app\models\Answer;

class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],            
            'auth' => [
                'class' => AuthAction::className(),
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        $question = Question::findRandom(Yii::$app->user->identity);
        if (is_null($question)) {
            return $this->render('win');
        }
        
        $answer = new Answer([
            'questionId' => $question->id,
            'userId' => Yii::$app->user->id,
            'score' => 0,
            'isCorrect' => 0,
        ]);
         
        if (Yii::$app->request->isAjax && $answer->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($answer);
        }
        
        if ($answer->load(Yii::$app->request->post()) && $answer->save()) {
            return $this->redirect(['answer/view', 'id' => $answer->id]);
        }
        
        return $this->render('index', [
            'question' => $question,
            'answer' => $answer,
        ]);
    }
    
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();
        $accountParams = [
            'sourceType' => Account::getSourceType($client->getId()),
            'sourceId' => Account::getSourceId($attributes),
        ];

        /** @var Account $account */
        $account = Account::find()->where($accountParams)->one();
        
        if (Yii::$app->user->isGuest) {
            if ($account && $account->user) { // login                
                Yii::$app->user->login($account->user, 30*24*60*60);
            } else { // signup
                $res = Account::signUp(Account::getSourceType($client->getId()), $attributes);
                if ($res && count($res->getErrors())) {
                    return $this->render('error', ['message' => print_r($res->getErrors(), true), 'name' => Yii::t('app', 'Registration error')]);
                }
            }
        } else { // user already logged in
            if (!$account) { // add auth provider
                $account = new Account($accountParams);
                $account->userId = Yii::$app->user->id;
                $account->save();
            }
        }
        
        return $this->goHome();
    }


    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        return $this->render('login');
    }

}
