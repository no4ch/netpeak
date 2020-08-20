<?php

namespace shop;

class App
{
    public static $app;
    
    public function __construct()
    {
        $patterns = array('/index.php&/', '/index.php/');
        $query = preg_replace($patterns, '', $_SERVER['QUERY_STRING']);
        session_start();
        self::$app = Registry::getInstance();
        $this->getConfig();
        new ErrorHandler();
        Router::dispatch($query);
    }
    
    protected function getConfig()
    {
        $config = require_once CONFIG.'/config.php';
        if (!empty($config)) {
            foreach ($config as $key => $value) {
                self::$app->setProperty($key, $value);
            }
        }
    }
}