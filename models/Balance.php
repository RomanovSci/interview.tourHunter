<?php

namespace app\models;

use app\traits\TimestampBehaviorTrait;
use yii\db\ActiveRecord;

class Balance extends ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'balance';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['user_id', 'required'],
            ['user_id', 'unique'],
            ['user_id', 'integer'],
        ];
    }


    /**
     * Get user
     *
     * @return null|ActiveRecord
     */
    public function getUser()
    {
        return $this->hasOne(User::class, [
            'id' => 'user_id',
        ])->one();
    }

    /**
     * Transfer funds
     *
     * @param float $amount
     * @return array
     */
    public function tranche($amount): array
    {
        $sender = \Yii::$app->user->identity;

        if ($sender->getAttribute('id') === $this->getAttribute('user_id')) {
            return [
                'success' => false,
                'error' => 'Can\'t transfer funds to yourself',
            ];
        }

        $dbTransaction = \Yii::$app->db->beginTransaction();

        try {
            $transaction = new Transaction();
            $this->setAttribute(
                'amount',
                $this->getAttribute('amount') + $amount
            );

            /** @var Balance $senderBalance */
            $senderBalance = $sender->getBalance();
            $senderBalance->setAttribute(
                'amount',
                $senderBalance->getAttribute('amount') - $amount
            );

            $transaction->setAttributes([
                'amount' => $amount,
                'sender_id' => $sender->getAttribute('id'),
                'recipient_id' => $this->getAttribute('user_id'),
            ]);

            if (
                !$this->save() ||
                !$senderBalance->save() ||
                !$transaction->save()
            ) {
                throw new \Exception('Transaction failed');
            }

            $dbTransaction->commit();
        } catch (\Exception $e) {
            $dbTransaction->rollBack();

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }

        return ['success' => true];
    }
}