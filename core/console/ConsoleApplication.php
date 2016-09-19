<?php

namespace silent\core\console;

use \silent\core\base\BaseApplication;
use silent\core\base\BaseException;

/**
 * Class ConsoleApplication for console application
 * @package silent\core\console
 */
class ConsoleApplication extends BaseApplication
{
    private $_scriptName;
    private $_args;
    private $_remainingArgs;


    /**
     * Initializes the application by creating the command runner.
     */
    protected function init()
    {
        parent::init();
        if(empty($_SERVER['argv']))
            die('This script must be run from the command line.');
        $this->_args = $this->_remainingArgs = $_SERVER['argv'];
    }


    /**
     *
     */
    public function processRequest()
    {
        $this->_scriptName = array_shift($this->_remainingArgs);
        if(! count($this->_remainingArgs) > 0) {
            die('please indicate the name of the controller.');
        }

        /** @var string generate controller path $routePath */
        $routePath = implode('/', $this->_remainingArgs);

        try {
            $this->runController($routePath);
            $exitCode = 0;
        } catch (BaseException $e) {
            $exitCode = 1;
            echo $e->getMessage();
        }

        $this->end($exitCode);
    }

}