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
            'articles' => $articles,
            'session' => filter_var_array($_SESSION)
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
            $data['content']        = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
            // $data['date_creation']  = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['url_images']     = filter_input(INPUT_POST, 'url_images', FILTER_SANITIZE_STRING);
            $data['update_article'] = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['posted']         = filter_input(INPUT_POST, 'posted', FILTER_SANITIZE_SPECIAL_CHARS);
            // debug($data);
            MainModel::loadModel("Articles")->update($data);

        } elseif (array_key_exists('title', $post)){
            
            $data= array();
            $data['title']          = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['slug']           = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['content']        = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);;
            $data['date_creation']  = htmlspecialchars(date("Y-m-d H:i:s"));
            $data['url_images']     = filter_input(INPUT_POST, 'url_images', FILTER_SANITIZE_STRING);
            // debug($data);
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
            // $comment = MainModel::loadModel("comments")->notOkComment($id);
            $this->render('article', [
                'article' => $article,
                'comments' => $comment,
                'session' => filter_var_array($_SESSION)
                ]);
        }
    }

    // public function toRead($id){        
    //     $posts_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    //     $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

    //     if (!empty($posts_id) and !empty($comment)) {
    //         $userId = $this->session->getUserVar('id');
    //         debug($userId);
    //         $this->createComment();
    //         $wcomments = $commentManager->getWaitingComments($posts_id, $idy);
    //         if ($wcomments !== false) {

    //             return $this->render('post.twig', array('post' => $post, 'comment' => $comments, 'wcomment' => $wcomments, 'p' => $page));
    //         }
    //         return $this->render('post.twig', array('post' => $post, 'comment' => $comments, 'p' => $page));
    //     }
    //     return $this->render('home.twig');
    // }
        
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
     * use Comment object  with function createComment in CommentsController
     */
    public function createComment()
    {     
        $posts_id        = filter_input(INPUT_POST, 'posts_id', FILTER_SANITIZE_NUMBER_INT);
        $userId          =  $this->session->getUserVar('id');
        $comment         = trim(filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS));
        $comments = new CommentsController();
        $comments->createComment($comment, $posts_id, $userId);
        
        $article = MainModel::loadModel("articles")->getOne($posts_id);
        $comments = MainModel::loadModel("Comments")->listComment($posts_id);

        $this->render('article', [
            'article' => $article,
            'comments'=> $comments,
            'session' => filter_var_array($_SESSION)
        ]);
    }
    
    public function delete($id){
        $comment = MainModel::loadModel("Articles")->delete($id);
        $this->redirect('admin_index');
    }
      
    public function postedArticles($id){
        $comment = MainModel::loadModel("Articles")->posted($id);
        $this->redirect('admin_index');
    }   
}
