<?php

namespace app\models;

use app\traits\TimestampBehaviorTrait;
use yii\db\ActiveRecord;

class Transaction extends ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['sender_id', 'recipient_id', 'amount'], 'required'],
            [['sender_id', 'recipient_id'], 'integer'],
        ];
    }

    /**
     * Get transaction owner
     *
     * @return null|ActiveRecord
     */
    public function getUser()
    {
        return $this->hasOne(User::class, [
            'id' => 'sender_id',
        ])->one();
    }
}