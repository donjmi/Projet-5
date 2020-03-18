<?php
namespace Blog\Controllers;

use Blog\Models\ArticlesModel;

class ArticlesController extends MainController
{

    public function index()
    {
        /**
         * load the model and his function + views
         */
        $articles = $this->loadModel("Articles")->getAll();
        $this->render('article', ['articles' => $articles]);  
    }

    public function read($id){
        
        $article = $this->loadModel("Articles")->getOne($id);
        $this->render('article', ['article' => $article]); 
    }
    
    public function update($id){
        
        $article = $this->loadModel("Articles")->getOne($id);
        $this->render('Article_edit', ['article' => $article]); 
    }

    public function deletexxx($id){
       
        $article = $this->loadModel("Articles")->getOne($id);
        $this->render('Article_delete', ['article' => $article]); 
        
    }
    /** new code */
    public function delete($id){
        $one = $this->loadModel("Articles")->getOne($id);
        $article = $this->loadModel("Articles")->delete($id); 
        $this->render('article_delete', Array(
            'article' => $article,
            'one' => $one
        )); 
    }

}
