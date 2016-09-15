<?php

// change the following paths if necessary
$yii = dirname(__FILE__).'/framework/yii.php';
$config = dirname(__FILE__). '/protected/config/main.php';

require_once($yii);
S1lent::createWebApplication($config)->run();
