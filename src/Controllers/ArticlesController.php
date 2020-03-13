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
        $article = $this->loadModel("Articles")->getOne($id);
        $this->render('Article_edit', ['article' => $article]); 
    }

    public function delete($id){
       
        $article = $this->loadModel("Articles")->deleteOne($id);
        $this->render('Admin_post', ['article' => $article]); 
    }

}
