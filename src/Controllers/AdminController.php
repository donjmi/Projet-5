<?php
namespace Blog\Controllers;

use Blog\Models\AdminModel;

class AdminController extends MainController
{

    public function edit()
    {
        /**
         * load the model and his function
         */
        $articles = $this->loadModel("Admin")->getAll();
            
        /**
         * page display 'edit' 
         * articles use to view in edit file
         */
        $this->render('article_edit', Array(
            'articles' => $articles
        ));  
    }
}