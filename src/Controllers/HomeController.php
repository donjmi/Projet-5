<?php
namespace Blog\Controllers;

use Blog\Models\HomeModel;

class HomeController extends MainController
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
        $this->render('home', ['articles' => $articles]);  
    }

    public function read($id){
        // echo  "l'identifiant est : ".$id;
        $article = $this->loadModel("Articles")->getOne($id);
        // debug($article);
        $this->render('article', ['article' => $article]); 
    }
}
