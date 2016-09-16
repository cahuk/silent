<?php

namespace silent\core;

/** defined main paaths */
define('SILENT_PATH_BASE', dirname(__DIR__));
define('SILENT_PATH_CORE', SILENT_PATH_BASE . DIRECTORY_SEPARATOR . 'core');
define('SILENT_PATH_APP', SILENT_PATH_BASE . DIRECTORY_SEPARATOR . 'app');

/** required Psr4Autoloader */
require_once SILENT_PATH_CORE . DIRECTORY_SEPARATOR . 'traits' . DIRECTORY_SEPARATOR . 'Psr4AutoloaderTrait.php';
use \silent\core\traits\Psr4AutoloaderTrait;

/**
 * Class SilentAutoload
 * @package silent\core
 */
class SilentAutoload
{
    /** get Psr4AutoloaderTrait */
    use Psr4AutoloaderTrait;

    /**
     * @var array namespaces and path
     */
    protected $frameworkNameSpaces = [
        'silent\\core\\' => SILENT_PATH_CORE,
        'silent\\app\\controllers\\' => SILENT_PATH_APP . DIRECTORY_SEPARATOR . 'controllers',
        'silent\\app\\components\\' => SILENT_PATH_APP . 'components',
    ];

    /**
     * Set framework namespaces and run parent register autoloader
     */
    public function SilentRegister()
    {
        // register the base directories for the namespace prefix
        foreach ($this->frameworkNameSpaces as $namespace => $path) {
            $this->addNamespace($namespace, realpath($path));
        }

        // register autoloader
        $this->register();
    }

}

(new SilentAutoload())->SilentRegister();