<?php


namespace app\Controllers;

use app\Models\AppModel;
use \shop\base\Controller as BaseController;

class AppController extends BaseController
{
    public function __construct($route) {
        parent::__construct($route);
        new AppModel();
    }
}