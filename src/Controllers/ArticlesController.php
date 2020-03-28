<?php
namespace Blog\Controllers;

use Blog\Models\ArticlesModel;
use Blog\Controllers\CommentsController;
use Blog\Models\MainModel;

class ArticlesController extends MainController
{
    // public function index()
    public function defaultMethod()
    {
        /**
         * load the models + methods + views
         */
        $articles = MainModel::loadModel("Articles")->getAll();
        // debug($articles);
        $this->render('article', ['articles' => $articles]);
    }

    public function create($id){
        
        $article = MainModel::loadModel("Articles")->getOne($id);
        $this->render('article_edit', Array(
            'article' => $article
        )); 
    }
    public function read($id){
        // debug($id);
        if (! empty($_POST)) {
            // debug($_POST);
            $this->createComment();
        } else {
            $article = MainModel::loadModel("articles")->getOne($id);
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
    }
    
    public function update($id){
        
        $article = MainModel::loadModel("Articles")->getOne($id);
        $this->render('Article_edit', ['article' => $article]); 
    }
    public function createComment()
    {
        $data = array();
        $data['posts_id'] = $_POST['posts_id'];
        $data['user_id'] = $_POST['user_id'];
        $data['comment'] = $_POST['comment'];
        $data['date_comment'] = date("Y-m-d H:i:s");
        $comment = new CommentsController();
        $comment->edit_com($data);
        
        /**
         * load the models + methods + views
         */
        $article = MainModel::loadModel("articles")->getOne($data['posts_id']);
        $comments = MainModel::loadModel("Comments")->getAll('posts_id', $_POST['posts_id']);
        $this->render('article', [
            'article' => $article,
            'comments' => $comments
        ]);
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
