<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use app\models\User;
use app\models\Question;

/**
 * 
 */
class StartController extends Controller
{
    /**
     * 
     * @throws Exception
     */
    public function actionIndex()
    {
        if (!User::find()->where(['id' => 1])->count()) {
            throw new Exception('User #1 not found');
        }
        User::updateAll(['role' => 2], ['id' => 1]);
        Question::updateAll(['submitterId' => 1], ['submitterId' => NULL]);
    }
}
