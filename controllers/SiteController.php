<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\authclient\AuthAction;
use app\models\Account;

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
        return $this->render('index');
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

}
