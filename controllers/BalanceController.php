<?php

namespace app\controllers;

use app\models\User;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class BalanceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::class,
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'tranche' => ['post'],
                ]
            ]
        ]);
    }

    /**
     * Balance trance action
     *
     * @return array
     */
    public function actionTranche(): array
    {
        $recipient = User::findOrCreateByUsername(
            \Yii::$app->request->bodyParams['recipient']
        );
        $trancheResult = $recipient->getBalance()->tranche(
            (float) \Yii::$app->request->bodyParams['amount']
        );

        return [
            'success' => $trancheResult,
        ];
    }
}