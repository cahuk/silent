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

    /** @var array application components */
    protected $components = [];

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
    public function end($status=0,$exit=true)
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
     * @return BaseController the currently active controller. Null is returned in this base class.
     */
    public function getController()
    {
        return null;
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
            $this->setComponent($id,$component);
    }


    /**
     * @param $id
     * @param $component
     */
    public function setComponent($id,$component)
    {
        if ($component===null)
        {
            unset($this->components[$id]);
            return;
        }
        else
        {
            $this->components[$id]=$component;
        }

    }


    /**
     * Default components
     */
    protected function registerCoreComponents()
    {
        $components= [
            'route' => '\\silent\\core\\components\\SilentRoute',
        ];
        $this->setComponents($components);
    }
}