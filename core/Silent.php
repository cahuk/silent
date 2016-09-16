<?php

namespace silent\core;

use silent\core\base\BaseException;

/**
 * Class Silent main file of framework
 * @package silent\core
 */
class Silent
{
    protected static $_app;

    /**
     * Use for web application
     * @param null $config
     * @return mixed
     */
    public static function createConsoleApplication()
    {
        return self::createApplication('\\silent\\core\\console\\ConsoleApplication',$config);
    }

    /**
     * Use for console application
     * @param null $config
     * @return mixed
     */
    public static function createWebApplication()
    {
        return self::createApplication('\\silent\\core\\web\\WebApplication',$config);
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
}