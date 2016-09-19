<?php

namespace silent\core\base;

use silent\core\Silent;

/**
 * Base application
 * Class BaseApplication
 * @package silent\core\base
 */
abstract class BaseApplication
{
    /**  @var string default controller */
    public $defaultController = 'default';

    private $_controller;
    private $_controllerId;

    /** @var array application components */
    protected $components = [];

    protected $layoutPath;
    protected $viewPath;


    /**
     * Constructor.
     * @param array $config application configuration.
     */
    public function __construct(array $config)
    {
        // create and register application as singleton
        Silent::setApplication($this);

        $this->registerCoreComponents();
        $this->configure($config);

        $this->init();
    }

    /**
     * Processes the request.
     * This is the place where the actual request processing work is done.
     * Derived classes should override this method.
     */
    abstract public function processRequest();


    /**
     * Runs the application.
     */
    public function run()
    {
        register_shutdown_function([$this, 'end'], 0, false);
        $this->processRequest();
    }


    /**
     * Terminates the application.
     * This method replaces PHP's exit() function by calling
     * @param integer $status exit status (value 0 means normal exit while other values mean abnormal exit).
     * @param boolean $exit whether to exit the current request.
     */
    public function end($status=0, $exit=true)
    {
        if($exit)
            exit($status);
    }


    /**
     * Initializes
     */
    protected function init()
    {
    }


    /**
     * Configures app
     * @param array $config the configuration array
     */
    public function configure(array $config)
    {
        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $this->$key = array_merge($this->$key, $value);
            } else {
                $this->$key=$value;
            }
        }
    }


    /**
     * Returns the request component.
     * @return BaseRequest the request component
     */
    public function getRequest()
    {
        return $this->getComponent('request');
    }


    /**
     * @param $id
     * @return mixed
     * @throws BaseException
     */
    public function getComponent($id)
    {
        if(isset($this->components[$id]) && is_object($this->components[$id])) {
            return $this->components[$id];
        } else {
            $className = $this->components[$id];
           return $this->components[$id] = Silent::createComponent($className);
        }
    }


    /**
     * @param $components
     */
    public function setComponents($components)
    {
        foreach($components as $id => $component)
            $this->setComponent($id, $component);
    }


    /**
     * @param $id
     * @param $component
     */
    public function setComponent($id, $component)
    {
        if ($component===null)
        {
            unset($this->components[$id]);
            return;
        }
        else
        {
            $this->components[$id] = $component;
        }

    }


    /**
     * Default components
     */
    protected function registerCoreComponents()
    {
        $components= [
        ];
        if($components) {
            $this->setComponents($components);

        }
    }


    /**
     * @return mixed
     */
    public function getLayoutPath()
    {
        return $this->layoutPath;
    }

    /**
     * @return mixed
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }

    /**
     * Creates the controller and performs the specified action.
     * @param string $route the route of the current request
     * @throws BaseException if the controller could not be created.
     */
    public function runController($route)
    {
        if(($ca = $this->createController($route)) !== null)
        {
            /** @var BaseController $controller  */
            list($controller, $actionID) = $ca;
            $this->_controller = $controller;
            $controller->run($actionID);
        }
        else
            throw new BaseException('Unable to resolve the request: ' . ($route==='' ? $this->defaultController: $route));
    }

    /**
     * @return BaseController the currently active controller
     */
    public function getController()
    {
        return $this->_controller;
    }


    /**
     * @param $route
     * @return BaseController|null
     */
    public function createController($route)
    {
        if (($route=trim($route, '/')) === '') {
            $route= $this->defaultController;
        }
        $action = '';
        $route .= '/';
        while (($pos = strpos($route, '/')) !== false)
        {
            $id = substr($route, 0 ,$pos);

            if (!preg_match('/^\w+$/', $id)) {
                return null;
            }

            /** controller */
            if (! isset($basePath))  // first segment
            {
                $className = ucfirst($id).'Controller';
                $basePath = (string) $id;
                $this->_controllerId = $id;
            } elseif (! $action) {
                $action = $this->parseActionParams($route);
            }
            $route = (string) substr($route, $pos + 1);

        }
        $classFullName = '\\silent\\app\\controllers\\' . $className;

        return [
            new $classFullName(),
            $action
        ];
    }

    /**
     * @param $pathInfo
     * @return string
     */
    protected function parseActionParams($pathInfo)
    {
        if(($pos = strpos($pathInfo, '/')) !== false)
        {
            $actionID = substr($pathInfo, 0, $pos);
            return $actionID;
        } else {
            return $pathInfo;
        }
    }

    /**
     * @return mixed
     */
    public function getControllerId()
    {
        return $this->_controllerId;
    }


}