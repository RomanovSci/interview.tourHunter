<?php

namespace tests\controllers;

use app\controllers\AuthController;
use Codeception\Test\Unit;
use Codeception\Util\Stub;

class AuthControllerTest extends Unit
{
    /**
     * @see AuthController::behaviors()
     */
    public function testBehaviors()
    {
        $controller = Stub::construct(AuthController::class, [1, 'test']);
        $this->assertInternalType('array', $controller->behaviors());
    }

}