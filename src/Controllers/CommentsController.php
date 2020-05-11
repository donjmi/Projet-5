<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class CommentsController extends MainController
{    
    /**
     * read
     *
     * @param  mixed $id
     * @return void
     */
    public function read($id)
    {
        $comment = MainModel::loadModel("comments")->listAll([
        'posts_id' => [$id, '='], 
        // 'comment' => 'très'
        ]);
        $this->render('comment', [
            'comments' => $comment
            ]);
    }
    
    /**
     * edit_com
     * this function is use in ArticleController
     * @param  mixed $data
     * @return void
     */
    // public function edit_com()
    public function edit_com($comment, $posts_id, $userId)
    {
        // $comment = MainModel::loadModel("Comments")->create($data);
        $comments = MainModel::loadModel("Comments")->addComment($comment, $posts_id, $userId);

    }
}
