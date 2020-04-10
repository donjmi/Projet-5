<?php
namespace Blog\Controllers;

use Blog\Models\ArticlesModel;
use Blog\Controllers\CommentsController;
use Blog\Models\MainModel;

/**
 * Class ArticlesController
 * Manages the Article item
 */
class ArticlesController extends MainController
{    
    /**
     * read
     *
     * @param  mixed $id
     * @return void
     */
    public function read($id){
        if (! empty($_POST)) {
            $this->createComment();
        } else {
            $article = MainModel::loadModel("articles")->getOne($id);
            // $comment = MainModel::loadModel("comments")->getAll('posts_id', $id);
            $comment = MainModel::loadModel("comments")->listAll([
            'posts_id' => [$id, ' = '], 
            // 'comment' => 'très'
            ]);

            $this->render('article', [
                'article' => $article,
                'comments' => $comment
                ]);
        }
    }
        
    /**
     * update
     *
     * @param  mixed $id
     * @return void
     */
    public function update($id){
        
        $article = MainModel::loadModel("Articles")->getOne($id);
        $this->render('Article_edit', ['article' => $article]); 
    }
      
    /**
     * createComment
     * use Comment object  with function edit_com in CommentsController
     */
    public function createComment()
    {
        $data = array();
        $data['posts_id'] = htmlspecialchars($_POST['posts_id']);
        $data['user_id'] = htmlspecialchars($_POST['user_id']);
        $data['comment'] = htmlspecialchars($_POST['comment']);
        $data['date_comment'] = date("Y-m-d H:i:s");
        $comment = new CommentsController();
        $comment->edit_com($data);
        
        $article = MainModel::loadModel("articles")->getOne($data['posts_id']);
        $comments = MainModel::loadModel("Comments")->getAll('posts_id', $_POST['posts_id']);
        $this->render('article', [
            'article' => $article,
            'comments' => $comments
        ]);
    }
    
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id){
        $one = MainModel::loadModel("Articles")->getOne($id);
        $article = MainModel::loadModel("Articles")->delete($id);
        $this->render('article_delete', Array(
            'article'   => $article,
            'one'       => $one
        )); 
    }
}
