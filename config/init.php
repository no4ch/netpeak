<?php

define("DEBUG", 1);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("CORE", ROOT . '/vendor/shop/core');
define("LIBS", ROOT . '/vendor/shop/core/libs');
define("CACHE", ROOT . '/storage/cache');
define("CONFIG", ROOT . '/config');
define("LAYOUT", 'default');
define("VIEWS", ROOT."/resources/views");
define("ROUTES", ROOT."/routes");


//make clean path
$app_path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
$app_path = preg_replace("#[^/]+$#", '', $app_path);
$app_path = str_replace('/public', '', $app_path);
$app_path = str_replace('/', '', $app_path);

define("PATH", $app_path);
define("DASHBOARD", PATH . '/dashboard');

require_once ROOT . "/vendor/autoload.php";