<?php
return [
    'id' => 'yii2example',
    'basePath' => __DIR__,
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2example',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ]
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@jamband/schemadump/template.php',
        ],
        'schemadump' => [
            'class' => 'jamband\schemadump\SchemaDumpController',
        ],
    ],
    'params' => [],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'fixture' => [
                    'class' => 'elisdn\gii\fixture\Generator',
                ],
            ],
        ]
    ]
];