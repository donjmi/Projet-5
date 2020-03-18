<?php
namespace Blog\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Blog\Models\ArticlesModel;

abstract class MainController
{
    protected $twig = null;

    /**
     * MainController constructor
     */
    public function __construct()
    {
        $loader = new FilesystemLoader('../src/Views');
        $this->twig = new Environment($loader, [
          'cache' => false,  //__DIR__ .'/tmp'
        ]); 
    }

    /**
     * Allows to load a model
     * @param string $model
     * @return void
     */
    public function loadModel(string $model)
    {      
        // create an instance of this model
        $model = 'Blog\\Models\\' . $model . 'Model';
        return new $model();
    }

    /**
     * extract($data) allows you to create a variable for each field
     * call twig function render
     */
    public function render(string $file, array $data = [])
    {
        extract($data);
        echo $this->twig->render($file . '.twig', $data); 
    }
}
