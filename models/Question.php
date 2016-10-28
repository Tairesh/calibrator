<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "questions".
 *
 * @property integer $id
 * @property string $text
 * @property double $answer
 * @property string $source
 * @property integer $submitterId
 * @property integer $dateSubmitted
 * @property integer $dateApproved
 *
 * @property Answer[] $answers
 * @property User[] $users
 */
class Question extends ActiveRecord
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
            [['text', 'answer'], 'required'],
            [['text'], 'string'],
            [['source'], 'string', 'max' => 255],
            [['dateSubmitted', 'dateApproved', 'submitterId'], 'integer', 'min' => 0],
            [['answer'], 'number'],
            [['submitterId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['submitterId' => 'id']],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'dateSubmitted',
                'updatedAtAttribute' => false,
            ],
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
            'source' => Yii::t('app', 'Source'),
            'submitterId' => Yii::t('app', 'Submitter ID'),
            'dateSubmitted' => Yii::t('app', 'Date Submitted'),
            'dateApproved' => Yii::t('app', 'Date Approved'),
        ];
    }
    
    public function delete()
    {
        $this->dateApproved = NULL;
        return $this->save();
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubmitter()
    {
        return $this->hasOne(User::className(), ['id' => 'submitterId']);
    }
    
    /**
     * 
     * @param string|array $where
     * @return integer
     */
    public static function approveAll($where = '')
    {
        return static::updateAll([
            'dateApproved' => time(),
        ], $where);
    }
    
    /**
     * 
     * @param boolean $save
     * @return boolean
     */
    public function approve($save = true)
    {
        $this->dateApproved = time();
        if ($save) {
            return $this->save();
        }
        return true;
    }


    /**
     * 
     * @param \app\models\User $user
     * @return static
     */
    public static function findRandom(User $user, $currentQuestionId = null)
    {
        return static::findBySql('SELECT q.* FROM '.static::tableName().' q 
            LEFT JOIN '.Answer::tableName().' a ON a.questionId = q.id AND a.userId = '.$user->id.' 
            WHERE a.id IS NULL AND q.dateApproved IS NOT NULL AND q.submitterId <> '.$user->id.'
            ORDER BY RANDOM()
            ')->one();
    }
}
