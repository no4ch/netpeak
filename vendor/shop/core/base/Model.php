<?php

namespace shop\base;

use shop\DB;

abstract class Model
{
    public $attributes = [];
    public $errors = [];
    public $rules = [];
    
    public function __construct()
    {
        DB::getInstance();
    }
}