<?php

namespace silent\app\controllers;

use silent\core\base\BaseController;

/**
 * Class DefaultController
 * @package silent\app\controllers
 */
class DefaultController extends BaseController
{

    public $pageTitle = 'DefaultController - Silent Framework';

    /**
     *
     */
    public function actionIndex()
    {
        $this->render('index', ['test' => 'Test data']);
    }


    /**
     *
     */
    public function actionTest()
    {
        $this->render('testPage', ['test' => 'Test data']);
    }
}