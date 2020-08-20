<?php

namespace shop;

class ErrorHandler
{
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
    }
    
    public function exceptionHandler($exeption)
    {
        $this->logErrors($exeption->getMessage(), $exeption->getFile(), $exeption->getLine());
        $this->displayError("Исключение", $exeption->getMessage(), $exeption->getFile(), $exeption->getLine(),
            $exeption->getCode());
    }
    
    public function logErrors($message = '', $file = '', $line = '')
    {
        $message = date('Y-m-d H:i:s').PHP_EOL.
            "Message: {$message}".PHP_EOL.
            "File: {$file}".PHP_EOL.
            "Line: {$file}".PHP_EOL
            .PHP_EOL;
        
        $destination = ROOT."/storage/logs/".date('Y-m-d-')."log.log";
        error_log($message, 3, $destination);
    }
    
    public function displayError($errorNumber, $errorText, $errorFile, $errorLine, $response = 404)
    {
        http_response_code($response);
        if ($response == 404 && !DEBUG) {
            require VIEWS."/errorsPages/404.php";
            die;
        }
        if (DEBUG) {
            require VIEWS."/errorsPages/dev.php";
        } else {
            require VIEWS."/errorsPages/prod.php";
            
        }
        die;
    }
}