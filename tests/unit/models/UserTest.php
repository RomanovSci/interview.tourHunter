<?php

namespace tests\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{
    public function testTableName()
    {
        $actualResult = User::tableName();
        $expectedResult = 'user';

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testFindIdentity()
    {
        $actualResult = User::findIdentity(1);
        $expectedResult = null;

        $this->assertSame($expectedResult, $actualResult);
    }
}
