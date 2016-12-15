<?php

namespace app\models;

/**
 * Источник OAuth-регистрации
 */
abstract class AccountSource
{
    /**
     * 
     */
    const GOOGLE = 1;
    
    /**
     * 
     */
    const VK = 2;
    
    /**
     * 
     */
    const VKAPP = 2;
    
    /**
     * 
     */
    const FACEBOOK = 4;
    
    /**
     * 
     */
    const TWITTER = 5;
    
}
