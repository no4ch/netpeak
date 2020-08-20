<?php


namespace shop\_traits;


trait Singleton
{
    private static $instance;
    
    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    
}