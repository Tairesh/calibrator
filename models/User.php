<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $photo
 * @property integer $gender
 * @property double $score
 * @property integer $answersCount
 * @property integer $ninetyCount
 * @property integer $fiftyCount
 * @property integer $questionsCount
 * @property integer $role
 * 
 * @property integer $ninetyPercent
 * @property integer $fiftyPercent
 *
 * @property Account[] $accounts
 * @property Answer[] $answers
 * @property Question[] $questions
 */
class User extends ActiveRecord implements IdentityInterface
{
            
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'photo'], 'required'],
            [['score'], 'number'],
            [['answersCount', 'ninetyCount', 'fiftyCount', 'questionsCount'], 'integer', 'min' => 0],
            [['name', 'photo'], 'string', 'max' => 255],
            [['gender', 'role'], 'integer', 'min' => 0, 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'photo' => Yii::t('app', 'Photo'),
            'gender' => Yii::t('app', 'Gender'),
            'score' => Yii::t('app', 'Score'),
            'answersCount' => Yii::t('app', 'Answers Count'),
            'ninetyCount' => Yii::t('app', 'Ninety Count'),
            'fiftyCount' => Yii::t('app', 'Fifty Count'),
            'ninetyPercent' => Yii::t('app', 'Ninety Count'),
            'fiftyPercent' => Yii::t('app', 'Fifty Count'),
            'questionsCount' => Yii::t('app', 'Questions Count'),
            'role' => Yii::t('app', 'Role'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['userId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['userId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id' => 'questionId'])->viaTable('answers', ['userId' => 'id']);
    }

    public function getAuthKey()
    {
        return md5($this->id.Yii::$app->params['cookieValidationKey']);
    }

    public function getId()
    {
        return $this->id;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() == $authKey;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
    
    public function getNinetyPercent()
    {
        return ($this->answersCount > 0) ? round(100*$this->ninetyCount/$this->answersCount) : 0;
    }
    
    public function getFiftyPercent()
    {
        return ($this->answersCount > 0) ? round(100*$this->fiftyCount/$this->answersCount) : 0;
    }
    
}
