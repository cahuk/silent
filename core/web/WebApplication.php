<?php

namespace silent\core\web;

use silent\core\base\BaseApplication;
use silent\core\base\BaseController;
use silent\core\base\BaseException;
use silent\core\base\BaseRequest;

/**
 * Class WebApplication for web application
 * @package silent\core\web
 */
class WebApplication extends BaseApplication
{
    /**  @var string default controller */
    public $defaultController = 'default';

    private $_controller;
    private $_controllerId;

    public function processRequest()
    {
        /** @var BaseRequest $request */
        $request = $this->getRequest();
        $this->runController($request->getPathInfo());
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
            throw new BaseException('Unable to resolve the request: ' . $route==='' ? $this->defaultController: $route);
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