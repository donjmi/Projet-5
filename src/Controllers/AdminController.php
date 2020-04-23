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
        $post = filter_input_array(INPUT_POST);
        if (array_key_exists('id', $post) && ! empty($post['id'])){
            
            $data= array();
            $data['title'] = $post['title'];
            $data['slug'] = $post['slug'];
            $data['content'] = $post['content'];
            $data['date_creation'] = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['url_images'] = $post['url_images'];
            
            $x = MainModel::loadModel("Admin")->createQuery('update',$data);

        } elseif (array_key_exists('title', $post)){
            
            $data= array();
            $data['title'] = $post['title'];
            $data['slug'] = $post['slug'];
            $data['content'] = $post['content'];
            $data['date_creation'] = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['url_images'] = $post['url_images'];

            $x = MainModel::loadModel("Admin")->createQuery('create',$data);

        }
        /**
         * load model and push into view 
         */
        $articles = MainModel::loadModel("Admin")->getAll();
        $this->render('admin/Admin_post', Array(
            'articles'  => $articles
        )); 
    }
    
}