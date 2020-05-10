<?php
namespace Blog\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Blog\Models\ArticlesModel;

abstract class MainController
{
    protected $twig = null;
    protected $notifications = null;
    protected $session; // session user
    protected $currentPage = null;
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
        
        $this->session = new SessionController();

    }

    /**
     * extract($data) allows you to create a variable for each field
     * call twig function render
     */
    public function render(string $file, array $data = [])
    {
        extract($data);
        $this->currentPage = $file;
        echo $this->twig->render($file . '.twig', $data);
        exit();
    }

    public function redirect($url){
        switch($url){
            case 'admin_users':
                $redirect = '/users/listUsers';
            break;
            case 'inscription':
                $redirect = '/users/listUsers';
            break;
            case 'User_membre':
                $redirect = '/auth/login';
            break;
            default:
                $redirect = '';
        }
        $this->currentPage = $url;
        header("Location: http://localhost/projet-5$redirect");
        exit();
    }
}
