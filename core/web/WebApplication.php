<?php

namespace silent\core\web;

use silent\core\base\BaseApplication;

/**
 * Class WebApplication for web application
 * @package silent\core\web
 */
class WebApplication extends BaseApplication
{
    public function processRequest()
    {
        // TODO: Implement processRequest() method.
    }

    /**
     * Initializes the application.
     * This method overrides the parent implementation by preloading the 'request' component.
     */
    protected function init()
    {
        parent::init();
        // preload 'request' so that it has chance to respond to onBeginRequest event.
        $this->getRequest();
    }

}