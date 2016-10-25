<?php
    /**
     *  @see http://www.yiiframework.com/doc-2.0/yii-authclient-collection.html
     */
    return [
        'vkontakte' => [
            'class' => 'yii\authclient\clients\VKontakte',
            'clientId' => '00000',
            'clientSecret' => '...',
            'attributeNames' => [
                'sex',
                'photo',
                'photo_big',
                'photo_50',
                'photo_400_orig'
            ]
        ],
    ];
