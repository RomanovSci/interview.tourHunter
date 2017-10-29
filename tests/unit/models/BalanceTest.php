<?php

namespace tests\models;

use app\models\Balance;
use Codeception\Test\Unit;

class BalanceTest extends Unit
{
    /**
     * @see Balance::tableName()
     */
    public function testTableName()
    {
        $this->assertSame('balance', Balance::tableName());
    }

    /**
     * @see Balance::rules()
     */
    public function testRules()
    {
        $balance = new Balance();
        $this->assertInternalType('array', $balance->rules());
    }
}