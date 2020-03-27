<?php
namespace Blog\Controllers;

use Blog\Models\CommentsModel;
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

    public function edit_com()
    {
            $data= array();
            // $data['id'] = $_POST['id'];
            $data['posts_id'] = $_POST['posts_id'];
            $data['user_id'] = $_POST['user_id'];
            $data['comment'] = $_POST['comment'];
            $data['date_comment'] = date("Y-m-d H:i:s");
            // debug($data);
            $x = MainModel::loadModel("Comments")->createQuery('create',$data);

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
}
