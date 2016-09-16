<?php

ini_set('display_errors', 1);

/** @var string $basePath */
$basePath = __DIR__ . DIRECTORY_SEPARATOR;

/** require autoloader and register it */
require_once $basePath . 'core' . DIRECTORY_SEPARATOR . 'SilentAutoload.php';

/** require composer vendor autoloader */
require_once $basePath . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use \silent\core\Silent;
use \Symfony\Component\HttpFoundation;




Silent::createWebApplication()->run();
