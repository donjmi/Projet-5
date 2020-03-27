<?php
namespace Blog\Controllers;

use Blog\Models\ArticlesModel;
use Blog\Models\MainModel;

class ArticlesController extends MainController
{
    public function index()
    {
        /**
         * load the models + methods + views
         */
        $articles = MainModel::loadModel("Articles")->getAll();
        $this->render('article', ['articles' => $articles]);  
    }

    public function create($id){
        
        $article = MainModel::loadModel("Articles")->getOne($id);
        $this->render('article_edit', Array(
            'article' => $article
        )); 
    }
    public function read($id){
        
        $article = MainModel::loadModel("Articles")->getOne($id);
        // $comment = MainModel::loadModel("comments")->getAll('posts_id', $id);
        $comment = MainModel::loadModel("comments")->listAll([
        'posts_id' => $id, 
        // 'comment' => 'très'
        ]);
        $this->render('article', [
            'article' => $article,
            'comments' => $comment
            ]); 
    }
    
    public function update($id){
        
        $article = MainModel::loadModel("Articles")->getOne($id);
        $this->render('Article_edit', ['article' => $article]); 
    }
    public function createComment($id){
        
        $article = MainModel::loadModel("Articles")->getOne($id);
        $this->render('Article_edit', ['article' => $article]); 
    }

    public function delete($id){
        $one = MainModel::loadModel("Articles")->getOne($id);
        $article = MainModel::loadModel("Articles")->delete($id);
        $this->render('article_delete', Array(
            'article'   => $article,
            'one'       => $one
        )); 
    }

}
