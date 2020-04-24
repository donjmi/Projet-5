<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class InscriptionController extends MainController
{    
    public function createUsers()
    {  
        $data= array();
        if (isset($_POST)){
            $data['id']         = htmlspecialchars($_POST['id']);
            $data['pseudo']     = htmlspecialchars($_POST['pseudo']);
            $data['email']      = htmlspecialchars($_POST['email']);
            $data['password']   = htmlspecialchars($_POST['password']);
            $data['role']       = htmlspecialchars($_POST['role']);
        }
        if (isset($_POST['formSignUp']) && $this->validateUsers('createUsers')){
            $data['password']   = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $user = MainModel::loadModel("Inscription")->createQuery('create',$data);
            // debug($user,'création ok');
            $this->redirect('admin_users');
        }

        $configs = $this->configSite();
        $configs['site']['label'] = 'Inscrivez-vous';

        $this->render('inscription', Array(
            'user'   => $data,
            'action'    => 'createUsers',
            'errors' => $this->notifications,
            'configs' => $configs,
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
    
 /*  ------------------ form verifications -----------------------  */

private function isAlpha(){
    $isOk = true;
    if (empty($_POST['pseudo'])){
        $this->notifications[] = "Votre pseudo n'est pas renseigné";
        $isOk = false;
    }

    return $isOk;
}
private function isUnik(string $formType){
    $isOk = true;
    if (empty($_POST['pseudo'])){
        $this->notifications[] = "Votre pseudo n'est pas renseigné";
        $isOk = false;
        
    }else {
        $options = array();
        $options['pseudo'] = [$_POST['pseudo']];
        if ($formType != 'createUsers'){
            $options['id'] = [$_POST['id'], '!='];
        }
        $pseudo = MainModel::loadModel("Users")->listAll($options);
        if (!empty($pseudo)){
            $this->notifications[] = "pseudo déjà utilisé";
            $isOk = false;
        }
    }
    return $isOk;
}

private function isEmail(string $formType){
    $isOk = true;
    if (empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $this->notifications[] = "votre email n'est pas valide";
        $isOk = false;
    }
    if ($_POST['email2']!== $_POST['email']){
        $this->notifications[] = "Veuillez saisir un email identique ";
        $isOk = false;
    }else {
        $options = array();
        $options['email'] = [$_POST['email']];
        if ($formType != 'createUsers'){
            $options['id'] = [$_POST['id'], '!='];
        }
        $email = MainModel::loadModel("Users")->listAll($options);
        if (!empty($email)){
            $this->notifications[] = "Cet Email déjà utilisé";
            $isOk = false;
        }
    }
    return $isOk;
    }

    private function isPassword(){
        $isOk = true;
        if (empty($_POST['password'])){
            $this->notifications[] = "Veuillez saisir votre password";
            $isOk = false;
        }
        if ($_POST['password2']!== $_POST['password']){
            $this->notifications[] = "Veuillez saisir un password identique";
            $isOk = false;
        }

        return $isOk;
    }
    
    /**
     * validateUsers
     *
     * @param  mixed $formType
     * @return void
     */
    private function validateUsers(string $formType){
        
        $isOk[] = $this->isEmail($formType);
        $isOk[] = $this->isAlpha();
        $isOk[] = $this->isUnik($formType);
        $isOk[] = $this->isPassword();
        
        return $isOk[0] && $isOk[1] && $isOk[2] && $isOk[3];
    } 



}