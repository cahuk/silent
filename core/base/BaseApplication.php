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
    /**
     * Constructor.
     * @param mixed $config application configuration.
     */
    public function __construct()
    {
        // create and register application as singleton
        Silent::setApplication($this);

       /* $this->preinit();

        $this->initSystemHandlers();
        $this->registerCoreComponents();

        $this->configure($config);
        $this->preloadComponents();

        $this->init();*/
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
        register_shutdown_function([$this,'end'], 0, false);
        $this->processRequest();
    }

    /**
     * Terminates the application.
     * This method replaces PHP's exit() function by calling
     * {@link onEndRequest} before exiting.
     * @param integer $status exit status (value 0 means normal exit while other values mean abnormal exit).
     * @param boolean $exit whether to exit the current request. This parameter has been available since version 1.1.5.
     * It defaults to true, meaning the PHP's exit() function will be called at the end of this method.
     */
    public function end($status=0,$exit=true)
    {
        if($exit)
            exit($status);
    }
}