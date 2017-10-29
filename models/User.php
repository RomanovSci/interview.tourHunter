<?php

namespace app\models;

use app\traits\TimestampBehaviorTrait;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    use TimestampBehaviorTrait;

    protected $id;
    protected $authKey;

    const RESPONSE_FAIL = ['success' => false];
    const RESPONSE_SUCCESS = ['success' => true];

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @param int|string $id
     * @return null|static
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return null|static
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne([
            'access_token' => $token
        ]);
    }

    /**
     * @param string $username
     * @return null|static
     */
    public static function findByUsername($username = '')
    {
        return self::findOne([
            'username' => $username
        ]);
    }

    /**
     * @param string $username
     * @return User|null|static
     */
    public static function findOrCreateByUsername($username = '')
    {
        $instance = self::findOne([
            'username' => $username,
        ]);

        if (!$instance) {
            $instance = new self();
            $instance->setAttribute('username', $username);

            if (!$instance->validate() || !$instance->save()) {
                return null;
            }
        }

        return $instance;
    }

    /**
     * Get users list with balance
     *
     * @return array|ActiveRecord[]
     */
    public static function fetchAll()
    {
        return self::find()
            ->select(['user.id', 'username', 'amount'])
            ->leftJoin('balance', 'user.id = balance.user_id')
            ->asArray()
            ->all();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {

                /** Generate access token */
                $this->setAttribute(
                    'access_token',
                    \Yii::$app->security->generateRandomString(16)
                );
            }

          return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     *
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        /**
         * Create balance for user
         * @var Balance $userBalance
         */
        $userBalance = new Balance();
        $userBalance->setAttribute('user_id', $this->getAttribute('id'));

        if (!$userBalance->save()) {
            $this->delete();
        }
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['username', 'required'],
            [['username', 'access_token'], 'string'],
            [['username', 'access_token'], 'unique'],
        ];
    }

    /**
     * Get user balance
     *
     * @return ActiveRecord
     */
    public function getBalance()
    {
        return Balance::findOne([
            'user_id' => $this->getAttribute('id')
        ]);
    }

    /**
     * Get user transactions
     *
     * @return array
     */
    public function getTransactions()
    {
        return Transaction::find()
            ->select([
                'amount',
                '(select username from user where sender_id = user.id) as sender_username',
                '(select username from user where recipient_id = user.id) as recipient_username',
                'created_at'
            ])
            ->where(['sender_id' => $this->getAttribute('id')])
            ->orWhere(['recipient_id' => $this->getAttribute('id')])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();
    }
}
