<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once
// works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : 
    define('SITE_ROOT', dirname(dirname(__FILE__)));

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

// load config file first
require_once(LIB_PATH.DS.'config.php');

require_once(LIB_PATH.DS.'functions.php');
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');
require_once(LIB_PATH.DS.'calculo.php');
require_once(LIB_PATH.DS.'tiempo.php');
require_once(LIB_PATH.DS.'ahorro.php');

// load database-related classes
require_once(LIB_PATH.DS.'user.php');

?>