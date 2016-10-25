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
 * @property double $score
 * @property integer $answersCount
 * @property integer $ninetyCount
 * @property integer $fiftyCount
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
            [['name'], 'required'],
            [['score'], 'number'],
            [['answersCount', 'ninetyCount', 'fiftyCount'], 'integer', 'min' => 0],
            [['name'], 'string', 'max' => 255],
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
            'score' => Yii::t('app', 'Score'),
            'answersCount' => Yii::t('app', 'Answers Count'),
            'ninetyCount' => Yii::t('app', 'Ninety Count'),
            'fiftyCount' => Yii::t('app', 'Fifty Count'),
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
