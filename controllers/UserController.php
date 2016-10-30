<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\AnswerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\CalibratorAccessRule;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    
    /** 
    * @inheritdoc 
    */ 
    public function behaviors() 
    { 
        return [ 
            'verbs' => [ 
                'class' => VerbFilter::className(), 
                'actions' => [ 
                    'delete' => ['POST'], 
                ], 
            ], 
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['admin', 'update', 'delete'],
                'ruleConfig' => [
                    'class' => CalibratorAccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],        
        ]; 
    } 

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /** 
     * Updates an existing User model. 
     * If update is successful, the browser will be redirected to the 'view' page. 
     * @param integer $id 
     * @return mixed 
     */ 
    public function actionUpdate($id) 
    { 
        $model = $this->findModel($id); 

        if ($model->load(Yii::$app->request->post()) && $model->save()) { 
            return $this->redirect(['view', 'id' => $model->id]); 
        } else { 
            return $this->render('update', [ 
                'model' => $model, 
            ]); 
        } 
    } 
		 
    /** 
     * Deletes an existing User model. 
     * If deletion is successful, the browser will be redirected to the 'index' page. 
     * @param integer $id 
     * @return mixed 
     */ 
    public function actionDelete($id) 
    { 
        $this->findModel($id)->delete(); 

        return $this->redirect(['index']); 
    } 
    
    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new AnswerSearch();
        $searchModel->userId = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['attributes' => ['-dateSubmitted']]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
