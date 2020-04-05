<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class UsersController extends MainController
{    
    /**
     * edit
     *
     * @return void
     */
    public function editUsers()
    {
        if (array_key_exists('id', $_POST) && ! empty($_POST['id'])){
            
            $data= array();
            $data['id']         = htmlspecialchars($_POST['id']);
            $data['pseudo']     = htmlspecialchars($_POST['pseudo']);
            $data['email']      = htmlspecialchars($_POST['email']);
            // $data['email2']     = htmlspecialchars($_POST['email2']);
            $data['password']   = sha1($_POST['password']);
            // $data['password2']  = sha1($_POST['password2']);
            $data['role']       = htmlspecialchars($_POST['role']);
            
            $x = MainModel::loadModel("Users")->createQuery('update',$data);
        
        } elseif (array_key_exists('email', $_POST)){

            $data= array();
            $data['id']         = htmlspecialchars($_POST['id']);
            $data['pseudo']     = htmlspecialchars($_POST['pseudo']);
            $data['email']      = htmlspecialchars($_POST['email']);
            // $data['email2']     = htmlspecialchars($_POST['email2']);
            $data['password']   = sha1($_POST['password']);
            // $data['password2']  = sha1($_POST['password2']);
            $data['role']       = "0";

            // debug($data);
            $x = MainModel::loadModel("Users")->createQuery('create',$data);

        }
        /**
         * load model and push into view 
         */
        $users = MainModel::loadModel("Users")->getAll();
        $this->render('admin_users', Array(
            'users'  => $users
        )); 
    }

    public function update($id){
        
        $user = MainModel::loadModel("Users")->getOne($id);
        $this->render('User_edit', ['user' => $user]); 
    }

    public function delete($id){
        $one = MainModel::loadModel("users")->getOne($id);
        $user = MainModel::loadModel("Users")->delete($id);
        $this->render('user_delete', Array(
            'user'   => $user,
            'one'    => $one
        )); 
    }
    
}