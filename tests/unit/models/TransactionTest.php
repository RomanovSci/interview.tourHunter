<?php

namespace tests\models;

use app\models\Transaction;
use Codeception\Test\Unit;

class TransactionTest extends Unit
{
    /**
     * @see Transaction::tableName()
     */
    public function testTableName()
    {
        $this->assertSame('transaction', Transaction::tableName());
    }

    /**
     * @see Transaction::rules()
     */
    public function testRules()
    {
        $transaction = new Transaction();
        $this->assertInternalType('array', $transaction->rules());
    }
}