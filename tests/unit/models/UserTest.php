<?php

namespace tests\models;

use app\models\User;
use Codeception\Util\Stub;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @see User::tableName()
     */
    public function testTableName()
    {
        $actualResult = User::tableName();
        $expectedResult = 'user';
        $this->assertSame($expectedResult, $actualResult);
    }

    /**
     * @see User::findIdentity()
     */
    public function testFindIdentity()
    {
        $actualResult = User::findIdentity(0);
        $this->assertSame(null, $actualResult);
    }

    /**
     * @see User::findIdentityByAccessToken()
     */
    public function testFindIdentityByAccessToken()
    {
        $actualResult = User::findIdentityByAccessToken('test');
        $this->assertSame(null, $actualResult);
    }

    /**
     * @see User::findByUsername()
     */
    public function testFindByUsername()
    {
        $actualResult = User::findByUsername('not exists user');
        $this->assertSame(null, $actualResult);
    }

    /**
     * @see User::findOrCreateByUsername()
     */
    public function testFindOrCreateByUsername()
    {
        $actualResult = User::findOrCreateByUsername('test');
        $expectedResult = User::class;
        $this->assertInstanceOf($expectedResult, $actualResult);
    }

    /**
     * @see User::fetchAll()
     */
    public function testFetchAll()
    {
        $actualResult = User::fetchAll();
        $this->assertInternalType('array', $actualResult);
    }

    /**
     * @see User::getId()
     */
    public function testGetId()
    {
        /** @var User $user */
        $user = Stub::make(User::class, ['id' => 1]);
        $actualResult = $user->getId();
        $this->assertSame(1, $actualResult);
    }

    /**
     * @see User::getAuthKey()
     */
    public function testGetAuthKey()
    {
        /** @var User $user */
        $user = Stub::make(User::class, ['authKey' => 1]);
        $actualResult = $user->getAuthKey();
        $this->assertSame(1, $actualResult);
    }

    /**
     * @see User::validateAuthKey()
     */
    public function testValidateAuthKey()
    {
        /** @var User $user */
        $user = Stub::make(
            User::class,
            [
                'getAuthKey' => function() { return 1; }
            ]);

        $actualResult = $user->validateAuthKey(1);
        $this->assertSame(true, $actualResult);
    }

    /**
     * @see User::getBalance()
     */
    public function testGetBalance()
    {
        /** @var User $user */
        $user = Stub::make(
            User::class,
            [
                'getAttribute' => function() { return 0; }
            ]);

        $actualResult = $user->getBalance();
        $this->assertSame(null, $actualResult);
    }

    /**
     * @see User::getTransactions()
     */
    public function testGetTransactions()
    {
        /** @var User $user */
        $user = Stub::make(
            User::class,
            [
                'getAttribute' => function() { return 0; }
            ]);

        $actualResult = $user->getTransactions();
        $this->assertSame([], $actualResult);
    }
}