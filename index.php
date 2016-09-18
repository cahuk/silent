<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

/** base path  */
define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);

/** application path  */
define('APP_PATH', BASE_PATH . 'app' . DIRECTORY_SEPARATOR);

/** require autoloader and register it */
require_once BASE_PATH . 'core' . DIRECTORY_SEPARATOR . 'SilentAutoload.php';

/** require composer vendor autoloader */
require_once BASE_PATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use \silent\core\Silent;
use \Symfony\Component\HttpFoundation;

$config = require_once 'app/config/main.php';

Silent::createWebApplication($config)->run();
