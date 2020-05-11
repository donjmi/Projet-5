<?php
namespace Blog\Controllers;

use Blog\Controllers\CommentsController;
use Blog\Models\MainModel;

/**
 * Class ArticlesController
 * Manages the Article item
 */
class ArticlesController extends MainController
{        
    /**
     * listArticles
     *
     * @return void
     */
    public function listArticles()
    {
        $articles = MainModel::loadModel("Articles")->getArticles();
        $this->render('articles', Array(
            'articles' => $articles
        ));  
    } 
    
    /**
     * edit with create or update
     *
     * @return void
     */
    public function edit()
    {
        $post = filter_input_array(INPUT_POST);
        if (array_key_exists('id', $post) && ! empty($post['id'])){
            
            $data= array();
            $data['id']          = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['title']          = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['slug']           = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['content']        = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);;
            $data['date_creation']  = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['url_images']     = filter_input(INPUT_POST, 'url_images', FILTER_SANITIZE_STRING);
            // debug($data);
            MainModel::loadModel("Articles")->update($data);

        } elseif (array_key_exists('title', $post)){
            
            $data= array();
            $data['title']          = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['slug']           = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['content']        = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);;
            $data['date_creation']  = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['url_images']     = filter_input(INPUT_POST, 'url_images', FILTER_SANITIZE_STRING);
            debug($data);
            MainModel::loadModel("Articles")->create($data);

        }

        $articles = MainModel::loadModel("Articles")->getAll();
        $this->render('admin/Admin_post', Array(
            'articles'  => $articles
        )); 
    }
    
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
            $article = MainModel::loadModel("articles")->getOneArticle($id);
            $comment = MainModel::loadModel("comments")->listComment($id);            
            // $comment = MainModel::loadModel("comments")->listAll([
            //     'posts_id' => [$id, ' = '], 
            //     // 'comment' => 'très'
            //     ]);
            $this->render('article', [
                'article' => $article,
                'comments' => $comment,
                'session' => filter_var_array($_SESSION)
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
        $posts_id        = filter_input(INPUT_POST, 'posts_id', FILTER_SANITIZE_NUMBER_INT);
        $userId          = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        $comment         = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS);
        $date_comment    = date("Y-m-d H:i:s");
        $validate        = filter_input(INPUT_POST, 'validate', FILTER_SANITIZE_NUMBER_INT);
        $comments = new CommentsController();
        $comments->edit_com($comment, $posts_id, $userId);
        
        $article = MainModel::loadModel("articles")->getOne($posts_id);
        $comments = MainModel::loadModel("Comments")->listComment($posts_id);

        $this->render('article', [
            'article' => $article,
            'comments'=> $comments,
            'session' => filter_var_array($_SESSION)
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
