<?php
return [
    'id' => 'yii2example',
    'basePath' => __DIR__,
    'components' => [
        'request' => [
            'enableCookieValidation' => false
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2example',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ]
    ],
    'params' => [],
];