<?php

namespace silent\core\web;

use silent\core\base\BaseApplication;
use silent\core\base\BaseRequest;

/**
 * Class WebApplication for web application
 * @package silent\core\web
 */
class WebApplication extends BaseApplication
{

    public function processRequest()
    {
        /** @var BaseRequest $request */
        $request = $this->getRequest();
        $this->runController($request->getPathInfo());
    }

}