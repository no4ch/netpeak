<?php


namespace shop;


use mysql_xdevapi\Exception;

class Router
{
    protected static $routes = [];
    protected static $route = [];
    
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }
    
    public static function getRoutes()
    {
        return self::$routes;
    }
    
    public static function getRoute()
    {
        return self::$route;
    }
    
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {
            $controller = 'app\Controllers\\'.self::$route['prefix'].self::$route['controller'].'Controller';
            if (class_exists($controller)) {
                $pageController = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']).'Action';
                if (method_exists($pageController, $action)) {
                    $pageController->$action();
                    $pageController->getView();
                } else {
                    throw new \Exception("В контроллере $controller не найден метод $action");
                }
            } else {
                throw new \Exception("$controller не найден", 404);
            }
        } else {
            throw new \Exception("Страница не найдена, увы", 404);
        }
    }
    
    public static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                    if ($key === 0 && stristr($value, '/', true) == 'dashboard') {
                        $route['prefix'] = self::upperCamelCase('dashboard');
                    }
                }
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] = self::upperCamelCase($route['prefix']).'\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
    
    protected static function upperCamelCase($name)
    {
        return str_replace('-', '', ucwords(strtolower($name), '-'));
    }
    
    protected static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }
    
    protected static function removeQueryString($url)
    {
        if ($url) {
            $params = explode('&', $url, 2);
            if (!strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }
    }
}