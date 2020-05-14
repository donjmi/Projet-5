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

    public function inputComment(){
        
    }
}
