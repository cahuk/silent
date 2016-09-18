<?php

namespace silent\core;

use silent\core\base\BaseException;

/**
 * Class Silent main file of framework
 * @package silent\core
 */
class Silent
{
    /** @var Silent  */
    protected static $_app;
    /** @var array  */
    private $_components = [];

    /**
     * Use for web application
     * @param array $config
     * @return \silent\core\console\ConsoleApplication
     */
    public static function createConsoleApplication($config)
    {
        return self::createApplication('\\silent\\core\\console\\ConsoleApplication',$config);
    }

    /**
     * Use for console application
     * @param array $config
     * @return \silent\core\web\WebApplication
     */
    public static function createWebApplication($config)
    {
        return self::createApplication('\\silent\\core\\web\\WebApplication', $config);
    }

    /**
     * Create new application
     * @param $class
     * @param null $config
     * @return mixed
     */
    public static function createApplication($class,$config=null)
    {
        return new $class($config);
    }

    /**
     * Returns the application singleton or null if the singleton has not been created yet.
     * @return \silent\core\base\BaseApplication application singleton, null if the singleton has not been created yet.
     */
    public static function app()
    {
        return self::$_app;
    }

    /**
     * Set instance of application
     * @param $app
     * @throws BaseException
     */
    public static function setApplication($app)
    {
        if(self::$_app===null || $app===null)
            self::$_app=$app;
        else
            throw new BaseException('Yii application can only be created once.');
    }


    /**
     * @param $config
     * @return mixed
     * @throws BaseException
     */
    public static function createComponent($config)
    {
        if(is_string($config))
        {
            $type=$config;
            $config=array();
        }
        elseif(isset($config['class']))
        {
            $type=$config['class'];
            unset($config['class']);
        }
        else
            throw new BaseException('Object configuration must be an array containing a "class" element.');

        if(($n=func_num_args())>1)
        {
            $args=func_get_args();
            if($n===2)
                $object=new $type($args[1]);
            elseif($n===3)
                $object=new $type($args[1],$args[2]);
            elseif($n===4)
                $object=new $type($args[1],$args[2],$args[3]);
            else
            {
                unset($args[0]);
                $class=new \ReflectionClass($type);
                $object=call_user_func_array([$class,'newInstance'],$args);
            }
        }
        else
            $object=new $type;

        foreach($config as $key=>$value)
            $object->$key=$value;

        return $object;
    }



}