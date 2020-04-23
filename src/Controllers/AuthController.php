<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class AuthController extends MainController
{    
    public function login()
    {  
        $data= array();
        $myPost = filter_input_array(INPUT_POST);
        if ($myPost){
            $data['email']      = $myPost['email'];
            $data['password']   = password_hash($myPost["password"],PASSWORD_BCRYPT);
        }
        if (isset($myPost['formAuth']) && $this->validateLogin()){
            
            debug('yes ok');
            $this->redirect('admin_users');
        }
        
        $configs = $this->configSite();
        $configs['site']['label'] = 'Se connecter';

        $this->render('login', Array(
            'user'      => $data,
            'action'    => 'login',
            'errors'    => $this->notifications,
            'configs'   => $configs,
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

        $isOk = true;

        $data = array();
        $data['email']         = htmlspecialchars($_POST['email']);
        $data['password']   = $_POST["password"];
           
        $bddPass = MainModel::loadModel("Auth")->getPass($data['email']);
            
            if(password_verify($data['password'], $bddPass['password'])){
                echo "ok";
            }else {
                echo "ahhhhhhhhhhhhhhhhhhhhhhhhh <br />";
                echo "input : " . $data['password'] . "<br />";
                echo "base : " . $bddPass['password'];

            }
            die();

        if (empty($verifLogin)){
            $this->notifications[] = "L'email ou le mot de passe n'est pas correct";
            $isOk = false;

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
        
        // $isOk[] = $this->isAlpha();
        $isOk[] = $this->isRegistered();
        // $isOk[] = $this->isEmail();
        // $isOk[] = $this->isPassword();   
        
        // return $isOk[0] && $isOk[1];
        return $isOk[0];
    } 



}