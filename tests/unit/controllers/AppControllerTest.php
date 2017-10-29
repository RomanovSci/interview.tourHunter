<?php

namespace tests\controllers;

use app\controllers\AppController;
use Codeception\Test\Unit;
use Codeception\Util\Stub;

class AppControllerTest extends Unit
{
    /**
     * @see AppController::behaviors()
     */
    public function testBehaviors()
    {
        $controller = Stub::construct(AppController::class, [1, 'test']);
        $this->assertInternalType('array', $controller->behaviors());
    }

    /**
     * @see AppController::actions()
     */
    public function testActions()
    {
        $controller = Stub::construct(AppController::class, [1, 'test']);
        $this->assertInternalType('array', $controller->actions());
    }

    /**
     * @see AppController::actionVersion()
     */
    public function testActionVersion()
    {
        $controller = Stub::construct(AppController::class, [1, 'test']);
        $result = $controller->actionVersion();
        $this->assertInternalType('array', $result);
        $this->assertSame([
            'version' => \Yii::$app->params['version']
        ], $result);
    }

    /**
     * @see AppController::actionIndex()
     */
    public function testActionIndex()
    {
        $controller = Stub::construct(AppController::class, [1, 'test'], [
            'render' => function() { return 'Render result'; }
        ]);
        $this->assertInternalType('string', $controller->actionIndex());
    }
}