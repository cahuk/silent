<?php

namespace silent\core\base;
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

    protected $_action;

    /**
     * @param $actionID
     * @throws BaseException
     */
    public function run($actionID)
    {
        if($actionID==='')
            $actionID=$this->defaultAction;

        try {
            $this->runAction($actionID);
        } catch (\Exception $e) {
            throw new BaseException("The system is unable to find the requested action " . $actionID=='' ? $this->defaultAction : $actionID);
        }
    }


    /**
     * @param $action
     */
    public function runAction($action)
    {
        $this->_action=$action;
        $this->{$action}();
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->_action;
    }
}