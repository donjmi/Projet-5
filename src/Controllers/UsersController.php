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
            'configs' => $configs,
        ));  
      
    }

    
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
        if (isset($_POST['formuser']) && $this->validateUsers('createUsers')){
            $data['password']   = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user = MainModel::loadModel("Users")->createQuery('create',$data);
            $this->redirect('admin_users');
        }
        $configs = $this->configSite();
        $configs['site']['label'] = 'Ajouter un nouvel utilisateur';

            
        $this->render('User_edit', Array(
            'user'   => $data,
            'action'    => 'createUsers',
            'errors' => $this->notifications,
            'configs' => $configs,
        ));
        
    }

    public function update($id){
        if (array_key_exists('id', $_POST) && ! empty($_POST['id'])){
         
            $data= array();
            $data['id']         = htmlspecialchars($_POST['id']);
            $data['pseudo']     = htmlspecialchars($_POST['pseudo']);
            $data['email']      = htmlspecialchars($_POST['email']);
            $data['email2']      = htmlspecialchars($_POST['email2']);
            $data['password']   = htmlspecialchars($_POST['password']);
            $data['password2']   = htmlspecialchars($_POST['password2']);
            $data['role']       = htmlspecialchars($_POST['role']);

            if (! $this->validateUsers('update')) {
                $this->render('User_edit', Array(
                    'user'      => $data,
                    'action'    => 'update',
                    'errors'    => $this->notifications,
                    'configs' => $this->configSite(),
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
                'configs' => $this->configSite(),
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

    private function isAlpha(){
        $isOk = true;
        if (empty($_POST['pseudo'])){
            $this->notifications[] = "saisir votre  pseudo";
            $isOk = false;
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
            $this->notifications[] = "Veuillez saisir le même email ";
            $isOk = false;
        }else {
            $options = array();
            $options['email'] = [$_POST['email']];
            if ($formType != 'createUsers'){
                $options['id'] = [$_POST['id'], '!='];
            }
            $email = MainModel::loadModel("Users")->listAll($options);
            if (!empty($email)){
                $this->notifications[] = "Email déjà utilisé";
                $isOk = false;
            }
        }
        return $isOk;
    }

    private function isPassword(){
        $isOk = true;
        if (empty($_POST['password'])){
            $this->notifications[] = "saisir votre  password";
            $isOk = false;
        }
        if ($_POST['password2']!== $_POST['password']){
            $this->notifications[] = "Veuillez saisir le même password";
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
        $isOk[] = $this->isPassword();
        
        return $isOk[0] && $isOk[1] && $isOk[2];
        //return eval(explode(' && ', $isOk));
    } 



}