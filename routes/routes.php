<?php

use shop\Router;


//dashboard
Router::add('^dashboard$', [
    'controller' => 'Main', 'action' => 'index', 'prefix' => 'dashboard'
]);
Router::add('^dashboard/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

//default user routes
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

