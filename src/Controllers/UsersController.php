<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class UsersController extends MainController
{    
    public function listUsers()
    {
        $configs = $this->configSite();
        $configs['site']['label'] = 'Ajouter un nouvel utilisateur';

        $users = MainModel::loadModel("Users")->getAll();
        $this->render('admin/admin_users', Array(
            'users'     => $users,            
            'action'    => 'createUsers',
            'errors'    => $this->notifications,
            'configs'   => $configs,
        ));  
      
    }

    
    public function createUsers()
    {  
        $data= array();
        $post = filter_input_array(INPUT_POST);
        if (isset($post)){
            $data['id']         = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $data['pseudo']     = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['email']      = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $data['password']   = filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING);
            $data['role']       = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_NUMBER_INT);
        }
        if (isset($post['formuser']) && $this->validateUsers('createUsers')){
            $data['password']   = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $user = MainModel::loadModel("Users")->createQuery('create',$data);
            $this->redirect('admin_users');
        }
        $configs = $this->configSite();
        $configs['site']['label'] = '';

            
        $this->render('inscription', Array(
            'user'      => $data,
            'action'    => 'createUsers',
            'errors'    => $this->notifications,
            'configs'   => $configs
        ));
        
    }

    public function update($id){
        $post = filter_input_array(INPUT_POST);
        if (array_key_exists('id', $post) && ! empty($post['id'])){
         
            $data= array();
            $data['id']         = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $data['pseudo']     = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['email']      = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $data['email2']     = filter_input(INPUT_POST, 'email2', FILTER_VALIDATE_EMAIL);
            $data['password']   = filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING);
            $data['password2']  = filter_input(INPUT_POST, 'Password2', FILTER_SANITIZE_STRING);
            $data['role']       = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_NUMBER_INT);

            if (! $this->validateUsers('update')) {
                $this->render('User_edit', Array(
                    'user'      => $data,
                    'action'    => 'update',
                    'errors'    => $this->notifications,
                    'configs'   => $this->configSite(),
                ));
            }
            $data['password']   = password_hash($_POST['password'], PASSWORD_DEFAULT);
            unset($data['email2']);
            unset($data['password2']);
            $user = MainModel::loadModel("Users")->createQuery('update',$data);
            // debug($user);
            $this->redirect('admin_users');
        } else {
            $user = MainModel::loadModel("Users")->getOne($id);
            $this->render('User_edit', Array(
                'user'   => $user,
                'action'    => 'update',
                'errors' => $this->notifications,
                'configs' => $this->configSite()
            ));
        }
    }

    public function delete($id){

        $one = MainModel::loadModel("users")->getOne($id);
        $user = MainModel::loadModel("Users")->delete($id);
        $this->render('user_delete', Array(
            'user'   => $user,
            'one'    => $one
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
    $post = filter_input_array(INPUT_POST);
    if (empty($post['pseudo'])){
        $this->notifications[] = "Votre pseudo n'est pas renseigné";
        $isOk = false;
    }

    return $isOk;
}
private function isUnik(string $formType){
    $isOk = true;
    $post = filter_input_array(INPUT_POST);
    if (empty($post['pseudo'])){
        $this->notifications[] = "Votre pseudo n'est pas renseigné";
        $isOk = false;
        
    }else {
        $options = array();
        $options['pseudo'] = [$post['pseudo']];
        if ($formType != 'createUsers'){
            $options['id'] = [$post['id'], '!='];
        }
        $pseudo = MainModel::loadModel("Users")->listAll($options);
        if (!empty($pseudo)){
            $this->notifications[] = "Ce pseudo est déjà utilisé";
            $isOk = false;
        }
    }
    return $isOk;
}

private function isEmail(string $formType){
    $isOk = true;
    $post = filter_input_array(INPUT_POST);
    if (empty($post['email']) || !filter_var($post['email'],FILTER_VALIDATE_EMAIL)){
        $this->notifications[] = "Votre email n'est pas au bon format";
        $isOk = false;
    }
    if ($post['email2']!== $post['email']){
        $this->notifications[] = "Veuillez saisir un email identique ";
        $isOk = false;
    }else {
        $options = array();
        $options['email'] = [$post['email']];
        if ($formType != 'createUsers'){
            $options['id'] = [$post['id'], '!='];
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
        $post = filter_input_array(INPUT_POST);
        if (empty($post['password'])){
            $this->notifications[] = "Veuillez saisir votre password";
            $isOk = false;
        }
        if ($post['password2']!== $post['password']){
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