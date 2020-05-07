<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class AuthController extends MainController
{    
    
    public function login()
    {  
        $data= array();
    
        $post = filter_input_array(INPUT_POST);
        if ($this->currentPage == "home"){// @TODO pages publiques
            session_start();
        } else if (! empty(session_id())) {// @TODO utilisateur connecté
            session_start();
        } else if (isset($post)){
            $data['email']      = $post['email'];
            $data['password']   = password_hash($post["password"],PASSWORD_BCRYPT);
            $user = $this->isRegistered();
            if (empty($user)){
                // debug('yes ok');
                session_start();
                $_SESSION['login'] = $user['pseudo'];
                $this->redirect('admin_users');
            }
        }
        
        $configs = $this->configSite();
        $configs['site']['label'] = 'Se connecter';
        $okConnect = "Vous êtes connecté, Bienvenue !!!";

        $this->render('inscription', Array(
            'user'      => $data,
            'action'    => 'login',
            'errors'    => $this->notifications,
            // 'configs'   => $configs,
            'bienvenue' => $okConnect
        ));
    }

    private function configSite()
    {
        return array(
            'site' => [
                'label' => "gestion de l'utilisateur",
            ]
        );
    }
    
 /*  ------------------login form verifications -----------------------  */

    private function isRegistered(){

        $isOk = null;
        $post = filter_input_array(INPUT_POST);
        $data['email']         = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $data['password']      = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $bddPass = MainModel::loadModel("Auth")->getPass($data['email']);
 
        if(!password_verify($post['password'], $bddPass['password'])){
            $this->notifications[] = "l'email et/ou mot de passe n'est pas correct";
            $isOk = $bddPass;
        }
        return $isOk;
    }
    
    /**
     * validateLogin
     *
     * @param  mixed $formType
     * @return void
     */
    private function validateLogin(){
        
        $isOk[] = $this->isRegistered();
        return $isOk[0];
    } 
/**  -------------------- session ----------      */
// public function createSession($user)
// {
//     $this->session['user'] = [
//         'id' => $user['id'],
//         'prenom' => $user['pseudo'],
//         'mail' => $user['mail'],
//         'role' => $user['role']
//     ];

//     $_SESSION['user'] = $this->session['user'];
// }

}