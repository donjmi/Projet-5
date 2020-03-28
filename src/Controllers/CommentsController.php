<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class CommentsController extends MainController
{
    public function read($id)
    {
        $comment = MainModel::loadModel("comments")->listAll([
        'posts_id' => $id, 
        // 'comment' => 'très'
        ]);
        $this->render('comment', [
            'comments' => $comment
            ]);
    }

    public function edit_com($data)
    {
        $x = MainModel::loadModel("Comments")->createQuery('create',$data);

    }
}
