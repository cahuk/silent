<?php

namespace silent\app\controllers;

use silent\core\base\BaseController;

/**
 * Class TestController
 * @package silent\app\controllers
 */
class TestController extends BaseController
{
    /**
     *
     */
    public function actionIndex()
    {
        $this->render('testingView', ['action' => 'actionIndex']);
    }


    /**
     *
     */
    public function actionTest()
    {
        $this->render('testingView', ['action' => 'actionTest']);
    }
}