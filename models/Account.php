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
    
    const SOURCE_GOOGLE = 1;
    const SOURCE_VK = 2;
    const SOURCE_VKAPP = 3;
    const SOURCE_FACEBOOK = 4;
    const SOURCE_TWITTER = 5;
    
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
        
        switch ($sourceType) {
            case static::SOURCE_GOOGLE:
                $user->name = $attributes['displayName'];
                break;
            case static::SOURCE_VK:
                $user->name = $attributes['first_name'].' '.$attributes['last_name'];
                break;
            default:
                return null;
        }
        
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
     * @param string $sourceName
     * @return integer
     */
    public static function getSourceType($sourceName)
    {
        switch ($sourceName) {
            case 'google':
                return static::SOURCE_GOOGLE;
            case 'facebook':
                return static::SOURCE_FACEBOOK;
            case 'twitter':
                return static::SOURCE_TWITTER;
            case 'vkontakte':
                return static::SOURCE_VK;
            case 'vkapp':
                return static::SOURCE_VKAPP;
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
