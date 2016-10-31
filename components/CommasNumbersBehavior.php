<?php

namespace app\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * 
 */
class CommasNumbersBehavior extends Behavior
{
    
    public $attributes;
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }
    
    /**
     * 
     * @param yii\base\Event $event
     */
    public function beforeValidate($event) {
        foreach ($this->attributes as $attribute) {
            $event->sender->$attribute = str_replace(' ', '', $event->sender->$attribute);
        }
    }

}
