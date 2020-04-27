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
            $data['id']          = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['title']          = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['slug']           = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['content']        = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);;
            $data['date_creation']  = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['url_images']     = filter_input(INPUT_POST, 'url_images', FILTER_SANITIZE_STRING);
            // debug($data);
            $article = MainModel::loadModel("Admin")->update($data);

        } elseif (array_key_exists('title', $post)){
            
            $data= array();
            $data['title']          = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['slug']           = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['content']        = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);;
            $data['date_creation']  = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['url_images']     = filter_input(INPUT_POST, 'url_images', FILTER_SANITIZE_STRING);

            $article = MainModel::loadModel("Admin")->create($data);

        }

        $articles = MainModel::loadModel("Admin")->getAll();
        $this->render('admin/Admin_post', Array(
            'articles'  => $articles
        )); 
    }
    
}