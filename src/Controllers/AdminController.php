<?php
namespace Blog\Controllers;

use Blog\Models\AdminModel;

class AdminController extends MainController
{
    public function edit()
    {
        if (array_key_exists('id', $_POST) && ! empty($_POST['id'])){
            
            $data= array();
            $data['id'] = $_POST['id'];
            $data['title'] = $_POST['title'];
            $data['slug'] = $_POST['slug'];
            $data['content'] = $_POST['content'];
            $data['date_creation'] = date("Y-m-d H:i:s");
            $data['url_images'] = $_POST['url_images'];
            

            $x = $this->loadModel("Admin")->createQuery('update',$data);

        } elseif (array_key_exists('title', $_POST)){
            
            $data= array();
            $data['title'] = $_POST['title'];
            $data['slug'] = $_POST['slug'];
            $data['content'] = $_POST['content'];
            $data['date_creation'] = date("Y-m-d H:i:s");
            $data['url_images'] = $_POST['url_images'];

            $x = $this->loadModel("Admin")->createQuery('create',$data);

        }
        /**
         * load model and push into view 
         */
        $articles = $this->loadModel("Admin")->getAll();
        $this->render('Admin_post', Array(
            'articles'  => $articles
        )); 
    }       

    public function delete()
    {
        if (array_key_exists('id', $_POST) && ! empty($_POST['id'])){
            
            $data= array();
            $data['id'] = $_POST['id'];
            $data['title'] = $_POST['title'];
            $data['slug'] = $_POST['slug'];
            $data['content'] = $_POST['content'];
            $data['date_creation'] = date("Y-m-d H:i:s");
            $data['url_images'] = $_POST['url_images'];
            

            $x = $this->loadModel("Admin")->createQuery('delete',$data);
            
        } 
    }

    public function xxerase($id){
  
        $articles = $this->loadModel("Admin")->erase($id); 
    }
    
}