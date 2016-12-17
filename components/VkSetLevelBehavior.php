<?php

namespace app\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\AccountSource;

/**
 * 
 */
class VkSetLevelBehavior extends Behavior
{
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
        ];
    }
        
    /**
     * 
     * @param yii\base\Event $event
     */
    public function afterInsert($event)
    {
        /* @var $user \app\models\User */
        $user = $event->sender->user;
        foreach ($user->accounts as $account) {
            if ($account->sourceType == AccountSource::VKAPP) {
                Yii::$app->vkapi->secureApi('secure.setUserLevel', [
                    'user_id' => $account->sourceId,
                    'level' => $user->answersCount,
                ]);
            }
        }
    }
    
}
