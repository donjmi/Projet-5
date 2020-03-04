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
        $this->render('article', ['articles' => $articles]);  
    }

    public function read($id){
        // echo  "l'identifiant est : ".$id;
        $article = $this->loadModel("Articles")->getOne($id);
        $this->render('article', ['article' => $article]); 
    }

    
    public function update($id){
        // echo  "l'identifiant est : ".$id;
        $article = $this->loadModel("Main")->update($id);
        $this->render('article', ['article' => $article]); 
    }

}
