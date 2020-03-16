<?php
namespace Blog;

class Router
{
   
    public function run()
    {    
        // On sépare les paramètres et on les met dans le tableau $params
        $url = explode('/', filter_var($_GET['page'], FILTER_SANITIZE_URL));

        // Si au moins 1 paramètre existe
        if ($url[0] != "") {
            // On sauvegarde le 1er paramètre dans $controller en mettant sa 1ère lettre en majuscule
            $controller = ucfirst($url[0]) . "Controller";
            // debug($controller);
            // On sauvegarde le 2ème paramètre dans $action s'il existe, sinon la méthode index()
            $action = isset($url[1]) ? $url[1] : 'index';
           
            // On appelle le contrôleur
            require_once('../src/Controllers/' . $controller . '.php');

            // On instancie le contrôleur

            $controller = 'Blog\\Controllers\\' . $controller;
            $controller = new $controller();
            

            // On appelle la méthode
            if (method_exists($controller, $action)) {
                /**
                 * unset : permet d'initialiser la variable $params
                 */
                unset($url[0]);
                unset($url[1]);

                // appelle une fonction le controlleur et la méthode en ajoutant des paramètres
                call_user_func_array([$controller, $action], $url);

            } else {
                http_response_code(404);
                echo "La page recherchée n'existe pas";
            }

        } else {
            
            require_once('../src/Controllers/HomeController.php');

            // On instancie le contrôleur
            $controller = 'Blog\\Controllers\\HomeController'; 
            $controller = new $controller();
            $controller->index();
        }
    }
}
