<?php
namespace Blog\Controllers;

use Blog\Models\AdminModel;

class AdminController extends MainController
{

    public function edit()
    {

        // $x = $this->loadModel("Admin")->test();
        if (array_key_exists('title', $_POST)){
            
            $data= array();
            $data['title'] = $_POST['title'];
            $data['slug'] = $_POST['slug'];
            $data['content'] = $_POST['content'];
            $data['date_creation'] = date("Y-m-d H:i:s");
            $data['url_images'] = $_POST['url_images'];
            //debug($data);

            $x = $this->loadModel("Admin")->createData($data);
        } 
        // debug($x);

        /**
         * load the model and his function
         */
        $articles = $this->loadModel("Admin")->getAll();
         
        /**
         * page display 'edit' 
         * articles use to view in edit file
         */
        $this->render('Admin_post', Array(
            'articles'  => $articles
        ));  
    }
}