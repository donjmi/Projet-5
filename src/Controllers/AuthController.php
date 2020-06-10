<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class AuthController extends MainController
{      
    /**
     * configSite : title pages
     * @return void
     */
    private function configSite()
    {
        return array(
            'site' => [
                'label' => "gestion de l'utilisateur",
            ]
        );
    }
    

    public function login()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            //on vérifie que email et password ne soient pas vide
        if (!empty($email) and !empty($password)) {
            //Vérifie que l’utilisateur existe avec le email
            $user = MainModel::loadModel("Auth")->verifyEmail($email);
            //Ensuite on récupère ses données
            if ($user !== false) {
                //Et on vérifie le password
               
                if (password_verify($password, $user['password'])) {
                    $this->alert('Bienvenue, vous êtes bien connecté !!');
                    $this->session->createSession($user['id'], $user['pseudo'], $user['email'], $user['role']);
                    $configs['site']['label'] = 'Modifier votre profil';
                    return $this->render('User_member', array(
                        'session' => filter_var_array($_SESSION),
                        'user'    => $user,
                        'configs' => $configs,
                    ));
                } else {
                    $this->notifications[] = "l'email et/ou mot de passe n'est pas correct";
                }
            } else {
                $this->notifications[] = "l'email et/ou mot de passe n'est pas correct";
            }
        }
        return $this->render('login', array(
                'errors'    => $this->notifications
                // 'configs'   => $configs
        ));
    }
    
    /**
     * login
     *@param string $model
     *@return void
     */
    public function member()
    {
        $user_session = filter_var_array($_SESSION['user']);
        $user = MainModel::loadModel("Users")->getOne($user_session['id']);
        $configs['site']['label'] = 'Modifier votre profil';
        return $this->render('User_member', array(
            'session' => filter_var_array($_SESSION),
            'user'    => $user,
            'configs' => $configs,
        ));
    }
    
    /**
     * logout
     *
     * @return void
     */
    public function logout(){
        SessionController::destroySession();
        $this->redirect('home');
    }

    public function confirmUser($id){

        $user  = MainModel::loadModel("Auth")->verifytoken($id);
        $url = explode('/', filter_input(INPUT_GET,'page', FILTER_SANITIZE_URL));

        if ($user['id'] == $url[2] && $user['token'] == $url[3]) {
            $this->session->createSession($user['id'], $user['pseudo'], $user['email'], $user['role']);
            MainModel::loadModel("Auth")->confirmAuth($id);
            $this->alert("Votre compte est activité !");
            return $this->render('User_member', array(
                'session' => filter_var_array($_SESSION),
                'user'    => $user
            ));
        }else {
            $this->render('login', Array(
                'session' => filter_var_array($_SESSION)));
            }
    }
}