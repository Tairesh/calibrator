<?php

namespace app\components;

use yii\filters\AccessRule;

/**
 * 
 */
class CalibratorAccessRule extends AccessRule
{
    
    /**
     * 
     * @param yii\web\User $user
     * @return boolean
     */
    public function matchRole($user)
    {
        
        if (parent::matchRole($user)) {
            return true;
        }
        
        if ($user->getIsGuest()) {
            return false;
        }        
        
        foreach ($this->roles as $role) {
            if ($role == $user->identity->role) {
                return true;
            }
        }
 
        return false;
    }
    
}
