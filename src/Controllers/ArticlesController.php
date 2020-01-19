<?php
namespace Blog\Controllers;

use Blog\Models\ArticlesModel;

class ArticlesController extends MainController
{

    public function index()
    {
        /**
         * load the model and his function
         */
        $articles = $this->loadModel("Articles")->getAll();
            
        /**
         * page display 'index' 
         * articles use to view in index file
         */
        $this->render('homepage2', ['articles' => $articles]);  
    }

    public function read($id){
        echo  "l'identifiant est : ".$id;

    }
}
