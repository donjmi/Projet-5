<?php
namespace Blog\Controllers;

use Blog\Models\ArticlesModel;

class ArticlesController extends MainController
{
    public function index()
    {
        /**
         * load the models + methods + views
         */
        $articles = $this->loadModel("Articles")->getAll();
        $this->render('article', ['articles' => $articles]);  
    }

    public function create($id){
        
        $article = $this->loadModel("Articles")->getOne($id);
        $this->render('article_edit', ['article' => $article]); 
    }
    public function read($id){
        
        $article = $this->loadModel("Articles")->getOne($id);
        $this->render('article', ['article' => $article]); 
    }
    
    public function update($id){
        
        $article = $this->loadModel("Articles")->getOne($id);
        $this->render('Article_edit', ['article' => $article]); 
    }

    public function delete($id){
        $one = $this->loadModel("Articles")->getOne($id);
        $article = $this->loadModel("Articles")->delete($id); 
        $this->render('article_delete', Array(
            'article' => $article,
            'one' => $one
        )); 
    }
}
