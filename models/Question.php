<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property integer $id
 * @property string $text
 * @property double $answer
 * @property integer $answersCount
 * @property integer $ninetyCount
 * @property integer $fiftyCount
 * @property integer $dateSubmitted
 * @property integer $dateApproved
 *
 * @property Answer[] $answers
 * @property User[] $users
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'answer', 'dateSubmitted'], 'required'],
            [['text'], 'string'],
            [['answersCount', 'ninetyCount', 'fiftyCount', 'dateSubmitted', 'dateApproved'], 'integer', 'min' => 0],
            [['answer'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'answer' => Yii::t('app', 'Answer'),
            'answersCount' => Yii::t('app', 'Answers Count'),
            'ninetyCount' => Yii::t('app', 'Ninety Count'),
            'fiftyCount' => Yii::t('app', 'Fifty Count'),
            'dateSubmitted' => Yii::t('app', 'Date Submitted'),
            'dateApproved' => Yii::t('app', 'Date Approved'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['questionId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'userId'])->viaTable('answers', ['questionId' => 'id']);
    }
}
