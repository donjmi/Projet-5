<?php
namespace Blog;

class Router
{
    
    /**
     * Default path to all controllers
     */
    const DEFAULT_PATH = 'Blog\Controllers\\';
    
    /**
     * Default controllers
     */
    const DEFAULT_CONTROLLER = 'HomeController';
    
    /**
     * Default method
     */
    const DEFAULT_METHOD = 'DefaultMethod';    
    /**
     * Requested controller
     * @var string
     */
    private $controller = self::DEFAULT_CONTROLLER;    
    /**
     * Requested method
     * @var string
     */
    private $method = self::DEFAULT_METHOD;    
    /**
     * Requested params
     * @var array
     */
    private $params = array();
        
    /**
     *Router constructor
     * Parses the URL, sets the Controller & his Method
     */
    public function __construct()
    {
        $this->parseUrl();
        $this->setController();
        $this->setMethod();
    }
    
    /**
     * Parses the URL to get the Controller & his Method & his parameters
     */
    public function parseUrl()
    {
        $url = explode('/', filter_input(INPUT_GET,'page', FILTER_SANITIZE_URL));
        
            if ($url[0] != "") 
            {
                $this->controller = array_shift($url);
                $this->method = isset($url[0]) ? array_shift($url) : 'index';
                $this->params = $url;
            }
    }
    
    /**
     * setController
     */
    public function setController()
    {
        $this->controller = ucfirst(strtolower($this->controller)) . 'Controller';
        $this->controller = self::DEFAULT_PATH . $this->controller;
       
        if (!class_exists($this->controller)) {
            $this->controller = self::DEFAULT_PATH . self::DEFAULT_CONTROLLER;
        }
    }
    
    /**
     * setMethod
     */
    public function setMethod()
    {
        $this->method = ucfirst(strtolower($this->method));

        if (!method_exists($this->controller, $this->method)) {
            $this->method = self::DEFAULT_METHOD;
        }
    }
    
    /**
     * Creates the Controller object & calls the Method + parameters on it
     */
    public function run()
    {
        $this->controller   = new $this->controller();
        $response           = call_user_func_array([$this->controller, $this->method], $this->params);
        echo filter_var($response);
    }
}