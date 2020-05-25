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
        $comments = MainModel::loadModel("Comments")->addComment($comment, $posts_id, $userId);

    }

    // public function update($id){
        
    //     $comments = MainModel::loadModel("Comments")->getOne($id);
    //     $this->render('Comment_edit', ['comment' => $comments]); 
    // }

    public function delete($id){
        $comment = MainModel::loadModel("Comments")->delete($id);
        $this->redirect('admin_index');
    }

    public function validateComment($id){
        $comment = MainModel::loadModel("Comments")->publish($id);
        $this->redirect('admin_index');
    }
}
