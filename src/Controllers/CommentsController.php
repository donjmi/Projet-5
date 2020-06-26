<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class CommentsController extends MainController
{    
        
    /**
     * createComment
     *
     * @param  mixed $comment
     * @param  mixed $posts_id
     * @param  mixed $userId
     * @return void
     */
    public function createComment($comment, $posts_id, $userId)
    {
        MainModel::loadModel("Comments")->addComment($comment, $posts_id, $userId);

    }
    
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id){
        if ($this->session->checkAdmin()) {
        MainModel::loadModel("Comments")->delete($id);
        $this->redirect('admin_index');
        }
    }
    
    /**
     * validateComment
     *
     * @param  mixed $id
     * @return void
     */
    public function validateComment($id){
        if ($this->session->checkAdmin()) {
        MainModel::loadModel("Comments")->publish($id);
        $this->redirect('admin_index');
        }
    }
}
