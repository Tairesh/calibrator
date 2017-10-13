<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use app\models\User;
use app\models\UserRole;

/**
 * 
 */
class StartController extends Controller
{
    /**
     * Sets user role to admin
     * @param integer $id User ID
     * @throws Exception
     */
    public function actionSetAdmin($id)
    {
        if (!User::find()->where(['id' => $id])->exists()) {
            throw new Exception("User #{$id} not found");
        }
        User::updateAll(['role' => UserRole::ADMIN], ['id' => $id]);
    }
}
