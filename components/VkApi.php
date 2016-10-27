<?php

namespace app\components;

/**
 * VkApi
 */
class VkApi extends \yii\base\Module
{
    
    public $appId;
    public $appKey;
    public $apiVersion = '5.59';
    
    public function __construct()
    {
        parent::__construct('vkapi');
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    /**
     * 
     * @param string $method
     * @param array $params
     * @return array
     */
    public function api($method, $params = [])
    {
        if (!isset($params['v'])) {
            $params['v'] = $this->apiVersion;
        }
        $params['https'] = 1;
        
        try {
            $data = file_get_contents('https://api.vk.com/method/'.$method.'?'.http_build_query($params));        
            return json_decode($data);
        } catch (\Exception $exception) {
            throw new \yii\base\Exception($exception->getMessage(), $exception->getCode());
        }
    }
    
    /**
     * 
     * @param integer|string $viewer_id
     * @param string $auth_key
     * @throws HttpException
     * @return boolean 
     */
    public function checkAuthKey($viewer_id, $auth_key)
    {
        $real_key = md5($this->appId.'_'.$viewer_id.'_'.$this->appKey);
        
        if ($real_key !== $auth_key) {
            throw new HttpException(403, Yii::t('app', 'Invalid auth key'));
        }
        
        return true;
    }
}
