<?php

namespace app\controllers;

use app\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class AuthController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'check' => ['get'],
                ]
            ]
        ]);
    }

    /**
     * Login or create new user
     *
     * @return array
     */
    public function actionLogin(): array
    {
        $params = \Yii::$app->request->getBodyParams();
        $user = User::findOrCreateByUsername($params['User']['username']);

        if ($user instanceof User) {
            return array_merge(User::RESPONSE_SUCCESS, [
               'token' => $user->getAttribute('access_token'),
            ]);
        }

        return User::RESPONSE_FAIL;
    }

    /**
     * Check user state
     *
     * @return array
     */
    public function actionCheck(): array
    {
        $user = User::findIdentityByAccessToken(
            \Yii::$app->request->getQueryParam('access_token')
        );

        if ($user instanceof User) {

            return [
                'authorized' => true,
                'username' => $user->getAttribute('username'),
                'amount' => $user->getBalance()->getAttribute('amount'),
                'transactions' => $user->getTransactions(),
            ];
        }

        return ['authorized' => false];
    }
}