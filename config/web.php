<?php

use yii\log\FileTarget;
use yii\gii\Module as GiiModule;
use yii\debug\Module as DebugModule;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'tourHunter',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
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
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
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

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => DebugModule::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => GiiModule::class,
    ];
}

return $config;
