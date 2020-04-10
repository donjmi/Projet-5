<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class UsersController extends MainController
{    
    
    public function listUsers()
    {
        $users = MainModel::loadModel("Users")->getAll();
        $this->render('admin_users', Array(
            'users'     => $users,            
            'action'    => 'createUsers',
            'errors'    => $this->notifications
        ));  
      
    }
    
    public function createUsers()
    {
        if (array_key_exists('id', $_POST) && ! empty($_POST['id'])){
            
            $data= array();
            $data['id']         = htmlspecialchars($_POST['id']);
            $data['pseudo']     = htmlspecialchars($_POST['pseudo']);
            $data['email']      = htmlspecialchars($_POST['email']);
            $data['password']   = sha1($_POST['password']);
            $data['role']       = htmlspecialchars($_POST['role']);
            $errors = $this->validateUsers();
            $user = MainModel::loadModel("Users")->createQuery('update',$data);
        
        } elseif (array_key_exists('email', $_POST)){
            
            $data= array();
            $data['id']         = htmlspecialchars($_POST['id']);
            $data['pseudo']     = htmlspecialchars($_POST['pseudo']);
            $data['email']      = htmlspecialchars($_POST['email']);
            $data['password']   = sha1($_POST['password']);
            $data['role']       = "0";
            
            $errors = $this->validateUsers();
            $user = MainModel::loadModel("Users")->createQuery('create',$data);
        }

        return $this->listUsers();
    }


    public function update($id){
        if (array_key_exists('id', $_POST) && ! empty($_POST['id'])){
         
            $data= array();
            $data['id']         = htmlspecialchars($_POST['id']);
            $data['pseudo']     = htmlspecialchars($_POST['pseudo']);
            $data['email']      = htmlspecialchars($_POST['email']);
            $data['password']   = sha1($_POST['password']);
            $data['role']       = htmlspecialchars($_POST['role']);
            if (! $this->validateUsers()) {
                $this->render('User_edit', Array(
                    'user' => $data,
                    'action'    => 'update',
                    'errors' => $this->notifications
                ));
            }
            $user = MainModel::loadModel("Users")->createQuery('update',$data);
            // debug($data);
            $this->redirect('admin_users');
        } else {
            $user = MainModel::loadModel("Users")->getOne($id);
            $this->render('User_edit', Array(
                'user'   => $user,
                'action'    => 'update',
                'errors' => $this->notifications
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

    public function validateUsers(){
        
        $isOk = true;

        if (empty($_POST['pseudo'])){
            $this->notifications[] = "saisir votre  pseudo";
            $isOk = false;
        }
        if (empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
            $this->notifications[] = "votre email n'est pas valide";
            $isOk = false;
        }
        if (empty($_POST['email']) || $_POST['email2']!== $_POST['email']){
            $this->notifications[] = "Veuillez saisir le même email ";
            $isOk = false;
        }else {
            $email = MainModel::loadModel("Users")->listAll([
                'email' => [$_POST['email']],
                'id'    => [$_POST['id'], '!=']
                ]);
            if (!empty($email)){
                $this->notifications[] = "Email déjà utilisé";
                $isOk = false;
            }
        }
        
        if (empty($_POST['password'])){
            $this->notifications[] = "saisir votre  password";
            $isOk = false;
        }
        if (empty($_POST['password2']) || $_POST['password2']!== $_POST['password']){
            $this->notifications[] = "Veuillez saisir le même password";
            $isOk = false;
        }
        return $isOk;

    }  
}