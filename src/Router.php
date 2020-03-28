<?php
namespace Blog;

class Router
{
    const DEFAULT_PATH = 'Blog\Controllers\\';
    const DEFAULT_CONTROLLER = 'HomeController';
    const DEFAULT_METHOD = 'DefaultMethod';
    private $controller = self::DEFAULT_CONTROLLER;
    private $method = self::DEFAULT_METHOD;
    private $params = array();
    
    public function __construct()
    {
        $this->parseUrl();
        $this->setController();
        $this->setMethod();
    }

    public function parseUrl()
    {
        $url = explode('/', filter_var($_GET['page'], FILTER_SANITIZE_URL));
        
            if ($url[0] != "") 
            {
                $this->controller = array_shift($url);
                $this->method = isset($url[0]) ? array_shift($url) : 'index';
                $this->params = $url;
            }
    }

    public function setController()
    {
        $this->controller = ucfirst(strtolower($this->controller)) . 'Controller';
        $this->controller = self::DEFAULT_PATH . $this->controller;
       
        if (!class_exists($this->controller)) {
            $this->controller = self::DEFAULT_PATH . self::DEFAULT_CONTROLLER;
        }
    }

    public function setMethod()
    {
        $this->method = ucfirst(strtolower($this->method));

        if (!method_exists($this->controller, $this->method)) {
            $this->method = self::DEFAULT_METHOD;
        }
    }

    public function run()
    {
        $this->controller   = new $this->controller();
        $response           = call_user_func_array([$this->controller, $this->method], $this->params);
        echo filter_var($response);
    }
}