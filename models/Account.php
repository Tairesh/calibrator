<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "accounts".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $sourceType
 * @property string $sourceId
 *
 * @property User $user
 */
class Account extends ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'sourceType', 'sourceId'], 'required'],
            [['userId', 'sourceType'], 'integer', 'min' => 0],
            [['sourceId'], 'string', 'max' => 255],
            [['sourceType', 'sourceId'], 'unique', 'targetAttribute' => ['sourceType', 'sourceId'], 'message' => 'The combination of Source Type and Source ID has already been taken.'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userId' => Yii::t('app', 'User ID'),
            'sourceType' => Yii::t('app', 'Source Type'),
            'sourceId' => Yii::t('app', 'Source ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
    
    /**
     * 
     * @param integer $sourceType
     * @param array $attributes
     * @return Account|User
     */
    public static function signUp($sourceType, $attributes)
    {
        
        $user = new User();        
        static::updateUserAttributesStatic($user, $sourceType, $attributes);
        
        $transaction = $user->getDb()->beginTransaction();
        if ($user->save()) {
            $account = new static([
                'userId' => $user->id,
                'sourceType' => $sourceType,
                'sourceId' => static::getSourceId($attributes),
            ]);
            if ($account->save()) {
                $transaction->commit();
                Yii::$app->user->login($user);
            }
            return $account;
        } else {
            return $user;
        }
    }
    
    /**
     * 
     * @param User $user
     * @param integer $sourceType
     * @param array $attributes
     */
    public static function updateUserAttributesStatic(User &$user, $sourceType, $attributes)
    {
        switch ($sourceType) {
            case AccountSource::VK:
            case AccountSource::VKAPP:
                $user->name = $attributes['first_name'].' '.$attributes['last_name'];
                $user->photo = $attributes['photo_50'];
                $user->gender = $attributes['sex'];
                break;
        }
    }
    
    /**
     * 
     * @param integer $sourceType
     * @param array $attributes
     */
    public function updateUserAttributes($sourceType, $attributes)
    {
        static::updateUserAttributesStatic($this->user, $sourceType, $attributes);
    }

    /**
     * 
     * @param string $sourceName
     * @return integer
     */
    public static function getSourceType($sourceName)
    {
        switch ($sourceName) {
            case 'google':
                return AccountSource::GOOGLE;
            case 'facebook':
                return AccountSource::FACEBOOK;
            case 'twitter':
                return AccountSource::TWITTER;
            case 'vkontakte':
                return AccountSource::VK;
            case 'vkapp':
                return AccountSource::VKAPP;
        }
    }
    
    /**
     * 
     * @param array $attributes
     * @return string
     */
    public static function getSourceId($attributes)
    {
        return (string)(isset($attributes['id'])?$attributes['id']:$attributes['uid']);
    }
}
