<?php

namespace tests\models;

use app\controllers\UserController;
use Codeception\Test\Unit;
use Codeception\Util\Stub;

class UserControllerTest extends Unit
{
    /**
     * @see UserController::behaviors()
     */
    public function testBehaviors()
    {
        $controller = Stub::construct(UserController::class, [1, 'test']);
        $this->assertInternalType('array', $controller->behaviors());
    }

    /**
     * @see UserController::actionAll()
     */
    public function testActionAll()
    {
        $controller = Stub::construct(UserController::class, [1, 'test']);
        $this->assertInternalType('array', $controller->behaviors());
    }
}