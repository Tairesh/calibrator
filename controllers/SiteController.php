<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\authclient\AuthAction;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\web\HttpException;
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
    public function actionIndex($skip = false)
    {
                
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        $currentQuestionId = Yii::$app->session->get('currentQuestionId');
        if (!$currentQuestionId || $skip) {
            $question = Question::findRandom(Yii::$app->user->identity);
            if (is_null($question)) {
                Yii::$app->session->set('currentQuestionId', null);
                return $this->render('win');
            }
            Yii::$app->session->set('currentQuestionId', $question->id);
        } else {
            $question = Question::findOne($currentQuestionId);
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
            Yii::$app->session->set('currentQuestionId', null);
            return $this->redirect(['answer/view', 'id' => $answer->id]);
        }
        
        return $this->render('index', [
            'question' => $question,
            'answer' => $answer,
        ]);
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        return $this->render('login');
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
    
    public function actionVkAppAuth($viewer_id, $auth_key, $user_id)
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }
        
//        $friends = json_decode(Yii::$app->request->get("api_result"))["response"];
        Yii::$app->vkapi->checkAuthKey($viewer_id, $auth_key);        
        
        $vkinfo = Yii::$app->vkapi->api('users.get',['user_ids' => $viewer_id])->response[0];
               
        $account = Account::find()->where([
            'sourceType' => Account::SOURCE_VKAPP,
            'sourceId' => $viewer_id,
        ])->one();
                
        if ($account) { // login
            /** @var \app\models\User */
            $user = $account->user;
            $user->name = $vkinfo->first_name.' '.$vkinfo->last_name;
            $user->save();
            
            Yii::$app->user->login($user, 30*24*60*60);
            
        } else { // signup
            $res = Account::signUp(Account::SOURCE_VKAPP, get_object_vars($vkinfo));
            if ($res && count($res->getErrors())) {
                return $this->render('error', ['message' => print_r($res->getErrors(), true), 'name' => Yii::t('app', 'Registration error')]);
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

}
