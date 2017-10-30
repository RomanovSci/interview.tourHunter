<?php

namespace app\controllers;

use app\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'all' => ['get'],
                ]
            ]
        ]);
    }

    /**
     * Fetch users list
     *
     * @return array
     */
    public function actionAll(): array
    {
        return User::fetchAll();
    }
}