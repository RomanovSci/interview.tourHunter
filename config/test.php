<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'tests',
    'basePath' => dirname(__DIR__),  
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],  
    'language' => 'en-US',
    'components' => [
        'user' => [
            'identityClass' => 'app\models\User',
            'enableSession' => false
        ],
        'request' => [
            'cookieValidationKey' => 'IeycYPYcVgCYNubf3oBvDJiBgivKMFoD',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'api/version' => 'app/version',
                'api/<controller:[\w\d\-]+>/<action:[\w\d\-]+>' => '<controller>/<action>',
                '<url:(.*)>' => 'app/index'
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'app/error',
        ],
    ],
    'params' => $params,
];
