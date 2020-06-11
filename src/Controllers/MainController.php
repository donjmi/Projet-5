<?php
namespace Blog\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

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
     * call twig function render
     *@param string
     *@property string|array
     */
    public function render(string $file, array $data = [])
    {
        $this->currentPage = $file;
        print_r($this->twig->render($file . '.twig', $data));
        exit();
    }
    
    /**
     * redirect
     *
     * @param  mixed $url
     */
    public function redirect($url){
        switch($url){
            case 'admin_users':
                $redirect = '/users/listUsers';
            break;
            case 'admin_index':
                $redirect = '/admin/edit';
            break;
            case 'inscription':
                $redirect = '/users/listUsers';
            break;
            case 'profil':
                $redirect = '/auth/login';
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

    /**
     * @param $message
     */
    public function alert($message)
    {
        $alert = "<script>alert('$message');</script>";
        // echo filter_var($alert);
        print_r(filter_var($alert));
    }
}
