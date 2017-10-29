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
            ['user_id', 'integer']
        ];
    }

    /**
     * Get user
     *
     * @return ActiveRecord
     */
    public function user()
    {
        return User::findOne([
            'id' => $this->getAttribute('user_id')
        ]);
    }

    /**
     * Transfer funds
     *
     * @param float $amount
     * @return bool
     */
    public function tranche($amount)
    {
        $dbTransaction = \Yii::$app->db->beginTransaction();

        try {
            $transaction = new Transaction();
            $this->setAttribute(
                'amount',
                $this->getAttribute('amount') + $amount
            );

            /** @var Balance $senderBalance */
            $senderBalance = \Yii::$app->user
                ->identity
                ->getBalance();

            $senderBalance->setAttribute(
                'amount',
                $senderBalance->getAttribute('amount') - $amount
            );

            $transactionAttributesMap = [
                'amount' => $amount,
                'sender_id' => \Yii::$app->user->identity->getAttribute('id'),
                'recipient_id' => $this->getAttribute('user_id'),
            ];

            foreach ($transactionAttributesMap as $attr => $value) {
                $transaction->setAttribute($attr, $value);
            }

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
            return false;
        }

        return true;
    }
}