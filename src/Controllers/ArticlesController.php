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
     * read the article or create the comment article
     *
     * @param  mixed $id
     * @return void
     */
    public function read($id){
        $post = filter_input_array(INPUT_POST);
        if (! empty($post)) {
            $this->createComment();
        } else {
            $article = MainModel::loadModel("articles")->getOne($id);
            $comment = MainModel::loadModel("comments")->listComment($id);
            // $comment = MainModel::loadModel("comments")->getAll('posts_id', $id);
            
            // $comment = MainModel::loadModel("comments")->listAll([
            //     'posts_id' => [$id, ' = '], 
            //     // 'comment' => 'très'
            //     ]);
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
        $data['posts_id']       = filter_input(INPUT_POST, 'posts_id', FILTER_SANITIZE_NUMBER_INT);
        $data['user_id']        = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        $data['comment']        = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS);
        $data['date_comment']   = date("Y-m-d H:i:s");
        $comment = new CommentsController();
        $comment->edit_com($data);
        
        
        $article = MainModel::loadModel("articles")->getOne($data['posts_id']);
        $comments = MainModel::loadModel("Comments")->getAll('posts_id', $data['posts_id']);
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
