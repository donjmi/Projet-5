<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;
use Blog\Models\Validate;

class UsersController extends MainController
{    
    public function listUsers()
    {
        $users = MainModel::loadModel("Users")->getAll();
        $this->render('admin/admin_users', Array(
            'users'     => $users,            
            'action'    => 'createUsers',
            'errors'    => $this->notifications
        ));  
      
    }
    public function createUsers()
    {  
            $data= array();
            if (isset($_POST['id'])){
                $data['id']         = htmlspecialchars($_POST['id']);
            }
            if (isset($_POST['pseudo'])){
                $data['pseudo']     = htmlspecialchars($_POST['pseudo']);
            }
            if (isset($_POST['email'])){
                $data['email']      = htmlspecialchars($_POST['email']);
            }
            if (isset($_POST['email2'])){
                $data['email2']      = htmlspecialchars($_POST['email2']);
            }
            if (isset($_POST['password']) && !empty($_POST['password'])){
                $data['password']   = sha1($_POST['password']);
            }
            if (isset($_POST['password2']) && !empty($_POST['password2'])){
                $data['password2']   = sha1($_POST['password2']);
            }
            if (isset($_POST['role'])){
                $data['role']       = htmlspecialchars($_POST['role']);
            }
            
            if (isset($_POST['formuser']) && $this->validateUsers('createUsers')){
                unset($data['email2']);
                unset($data['password2']);
                $user = MainModel::loadModel("Users")->createQuery('create',$data);
                $this->redirect('admin/admin_users');
            }

        $this->render('User_edit', Array(
            'user'   => $data,
            'action'    => 'createUsers',
            'errors' => $this->notifications
        ));
    
    }

    public function update($id){
        if (array_key_exists('id', $_POST) && ! empty($_POST['id'])){
         
            $data= array();
            $data['id']         = htmlspecialchars($_POST['id']);
            $data['pseudo']     = htmlspecialchars($_POST['pseudo']);
            $data['email']      = htmlspecialchars($_POST['email']);
            $data['password']   = sha1($_POST['password']);
            $data['role']       = htmlspecialchars($_POST['role']);

            if (! $this->validateUsers('update')) {
                $this->render('User_edit', Array(
                    'user'      => $data,
                    'action'    => 'update',
                    'errors'    => $this->notifications
                ));
            }
            $user = MainModel::loadModel("Users")->createQuery('update',$data);
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

    public function validateUsers(string $formType){
        
        $isOk = true;

        if (empty($_POST['pseudo'])){
            $this->notifications[] = "saisir votre  pseudo";
            $isOk = false;
        }
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



}