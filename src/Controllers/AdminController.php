<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class AdminController extends MainController
{    
    /**
     * edit
     *
     * @return void
     */
    public function edit()
    {
        if (array_key_exists('id', $_POST) && ! empty($_POST['id'])){
            
            $data= array();
            $data['id'] = $_POST['id'];
            $data['title'] = htmlspecialchars($_POST['title']);
            $data['slug'] = htmlspecialchars($_POST['slug']);
            $data['content'] = htmlspecialchars($_POST['content']);
            $data['date_creation'] = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['url_images'] = htmlspecialchars($_POST['url_images']);
            
            $x = MainModel::loadModel("Admin")->createQuery('update',$data);

        } elseif (array_key_exists('title', $_POST)){
            
            $data= array();
            $data['title'] = htmlspecialchars($_POST['title']);
            $data['slug'] = htmlspecialchars($_POST['slug']);
            $data['content'] = htmlspecialchars($_POST['content']);
            $data['date_creation'] = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['url_images'] = htmlspecialchars($_POST['url_images']);

            $x = MainModel::loadModel("Admin")->createQuery('create',$data);

        }
        /**
         * load model and push into view 
         */
        $articles = MainModel::loadModel("Admin")->getAll();
        $this->render('Admin_post', Array(
            'articles'  => $articles
        )); 
    }
    
}