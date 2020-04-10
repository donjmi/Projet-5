<?php
namespace Blog\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Blog\Models\ArticlesModel;

abstract class MainController
{
    protected $twig = null;
    protected $notifications = null;

    /**
     * MainController constructor
     */
    public function __construct()
    {
        $loader = new FilesystemLoader('../src/Views');
        $this->twig = new Environment($loader, [
          'cache' => false,  //__DIR__ .'/tmp'
        ]);
        $this->notifications = array();
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

    public function redirect($url){
        switch($url){
            case 'admin_users':
                $redirect = '/users/createUsers';
            break;
            default:
        }
        header("Location: http://localhost/projet-5$redirect");
        exit();
    }
}
