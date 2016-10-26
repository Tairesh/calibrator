<?php

namespace app\controllers;

use Yii;
use app\models\Answer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;

/**
 * AnswerController implements the CRUD actions for Answer model.
 */
class AnswerController extends Controller
{

    /**
     * Displays a single Answer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        if (Yii::$app->user->isGuest || Yii::$app->user->id != $model->userId) {
            throw new HttpException(403, Yii::t('app', 'You have not access to view this page'));
        }
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Answer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Answer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Answer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
