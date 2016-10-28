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
 * @property Account[] $accounts
 * @property Answer[] $answers
 * @property Question[] $questions
 */
class User extends ActiveRecord implements IdentityInterface
{
    
    /**
     * Обычный юзер
     */
    const ROLE_USER = 0;
    
    /**
     * Модератор (может принимать заявки на вопросы и создавать их)
     */
    const ROLE_MODERATOR = 1;
    
    /**
     * Администратор (-//- и может назначать модераторов)
     */
    const ROLE_ADMIN = 2;
    
    // пол
    const GENDER_UNKNOWN = 0;
    const GENDER_FEMALE = 1;
    const GENDER_MALE = 2;
    
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

}
