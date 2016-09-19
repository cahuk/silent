<?php

namespace silent\core\base;

use silent\core\components\exceptions\BadActionException;
use silent\core\components\exceptions\ViewNotFoundException;
use silent\core\Silent;

/**
 * Class BaseController
 * @package silent\core\base
 */
class BaseController
{
    /**
     * @var string defaults to 'index'.
     */
    public $defaultAction = 'index';

    protected $_action = '';

    /** @var string  */
    public $layout = 'main';

    protected $layoutPath;
    protected $viewPath;

    public $pageTitle = '';


    /**
     * @param $actionID
     * @throws BaseException
     */
    public function run($actionID)
    {
        if($actionID === '')
            $actionID = $this->defaultAction;

        try {
            $this->runAction($actionID);
        } catch (BadActionException $e) {
            echo $e->getMessage();
        }
    }


    /**
     * @param $action
     */
    public function runAction($action)
    {
        $this->_action = $action;
        $controllerAction = 'action'.$action;
        if (method_exists($this, $controllerAction)) {
            $this->{$controllerAction}();
        } else {
            throw new BadActionException("The system is unable to find the requested action " . ($action=='' ? $this->defaultAction : $action));
        }
    }


    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * @param $view
     * @param null $data
     * @param bool $return
     * @return mixed
     */
    public function render($view, $data=null, $return=false)
    {
        $output = $this->renderPartial($view, $data, true);

        if(($layoutFile = $this->getLayoutFile($this->layout)) !== false )
            $output = $this->renderFile($layoutFile, ['content'=>$output], true);

        if($return)
            return $output;
        else
            echo $output;

    }


    /**
     * @param $view
     * @param null $data
     * @param bool $return
     * @return mixed
     * @throws ViewNotFoundException
     */
    public function renderPartial($view, $data=null, $return=false)
    {
        if (($viewFile = $this->getViewFile($view)) !== false)
        {
            $output = $this->renderFile($viewFile, $data, true);

            if($return)
                return $output;
            else
                echo $output;
        }
        else
            throw new ViewNotFoundException(get_class($this) . "  cannot find the requested view '$view'");
    }


    /**
     * @param $viewName
     * @return mixed
     */
    public function getViewFile($viewName)
    {
        return $this->resolveViewFile($viewName, $this->getViewPath());
    }


    /**
     * @param $layoutName
     * @return bool
     */
    public function getLayoutFile($layoutName)
    {
        return $this->resolveViewFile($layoutName, $this->getLayoutPath(), true);
    }

    /**
     * @param $viewFile
     * @param null $data
     * @param bool $return
     * @return mixed
     */
    public function renderFile($viewFile,$data=null,$return=false)
    {
        $content = $this->renderInternal($viewFile, $data, $return);
        return $content;
    }


    /**
     * @param $_viewFile_
     * @param null $_data_
     * @param bool $_return_
     * @return string
     */
    public function renderInternal($_viewFile_,$_data_=null,$_return_=false)
    {
        // we use special variable names here to avoid conflict when extracting data
        if (is_array($_data_))
            extract($_data_, EXTR_PREFIX_SAME, 'data');
        else
            $data = $_data_;
        if ($_return_)
        {
            ob_start();
            ob_implicit_flush(false);
            require($_viewFile_);
            return ob_get_clean();
        }
        else
            require($_viewFile_);
    }


    /**
     * @return mixed
     */
    public function getViewPath()
    {
        if($this->viewPath === null) {
            $this->viewPath = Silent::app()->getViewPath();
        }
        return $this->viewPath;
    }

    /**
     * @return mixed
     */
    public function getLayoutPath()
    {
        if($this->layoutPath === null) {
            $this->layoutPath = Silent::app()->getLayoutPath();
        }
        return $this->layoutPath;
    }

    /**
     * @param $viewName
     * @param $viewPath
     * @return bool|string
     */
    public function resolveViewFile($viewName, $viewPath, $layout = false)
    {
        if(empty($viewName))
            return false;

        $extension = '.php';
        $controller = '';
        if($layout == false) {
            $controller = $this->getControllerId() . DIRECTORY_SEPARATOR;
        }
        $viewFile = $viewPath.DIRECTORY_SEPARATOR. $controller . $viewName.$extension;

        return (is_file($viewFile) ? $viewFile : false);
    }

    /**
     * @return mixed
     */
    public function getControllerId()
    {
        return Silent::app()->getControllerId();
    }
}