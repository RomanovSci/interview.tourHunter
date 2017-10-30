<?php

namespace tests\controllers;

use app\controllers\BalanceController;
use Codeception\Test\Unit;
use Codeception\Util\Stub;

class BalanceControllerTest extends Unit
{
    /**
     * @see BalanceController::behaviors()
     */
    public function testBehaviors()
    {
        $controller = Stub::construct(BalanceController::class, [1, 'test']);
        $this->assertInternalType('array', $controller->behaviors());
    }
}