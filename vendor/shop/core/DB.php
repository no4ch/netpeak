<?php


namespace shop;


use RedBeanPHP\R;
use shop\_traits\Singleton;

class DB
{
    use Singleton;
    
    protected function __construct() {
        $db = require_once CONFIG. '/db_accesses.php';
        R::setup($db['dsn'], $db['user'], $db['password']);
        if (!R::testConnection()){
            throw new \Exception("Не удалось подключится к бд" . __METHOD__);
        }
        R::freeze(true);
        if (DEBUG){
            R::debug(true, 1);
        }
    }
}