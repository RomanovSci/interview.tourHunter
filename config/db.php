<?php

use yii\db\Connection;

return [
    'class' => Connection::class,
    'dsn' => 'mysql:host=localhost;dbname='.getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_SECRET'),
    'charset' => 'utf8',
];
