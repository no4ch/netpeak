<?php


namespace shop\base;


class View
{
    public $route;
    public $controller;
    public $model;
    public $view;
    public $prefix;
    public $layout;
    public $data = [];
    public $meta = [];
    
    public function __construct($route, $layout = '', $view = '', $meta)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->model = $route['controller'];
        $this->view = $view;
        $this->prefix = $route['prefix'];
        $this->meta = $meta;
        
        if ($layout === false) {
            $this->layout = $layout;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
    }
    
    public function render($data)
    {
        if (is_array($data)) {
            extract($data);
        }
        $viewLayoutFile = VIEWS."/{$this->prefix}{$this->controller}/{$this->view}.php";
        $viewLayoutFile = strtolower($viewLayoutFile);
        
        if (!is_file($viewLayoutFile)) {
            throw new \Exception("Не найден вид {$viewLayoutFile}", 500);
        }
        
        ob_start();
        require $viewLayoutFile;
        $content = ob_get_clean();
        
        if ($this->layout !== false) {
            $layoutFile = VIEWS."/layouts/{$this->layout}.php";
            if (is_file($layoutFile)) {
                require_once $layoutFile;
            } else {
                throw new \Exception("Не найден шаблон {$this->layout}");
            }
        }
    }
    
    public function getMeta()
    {
        $output = "<title> {$this->meta['title']}</title>";
        $output .= "<meta name=\"description\" content=\"{$this->meta['description']}\">";
        $output .= "<meta name=\"keywords\" content=\"{$this->meta['keywords']}\">";
        
        return $output;
    }
}