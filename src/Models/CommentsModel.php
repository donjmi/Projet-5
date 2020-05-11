<?php
namespace Blog\Models;

class CommentsModel extends MainModel{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        // // table database
        $this->table = "comments";

        // get cnx
        $this->getConnection();
    }

    public function listComment($id)
    {       
            $req = "SELECT  Comments.id,
                            Comments.posts_id,
                            Comments.user_id,
                            Comments.comment,
                            Comments.date_comment,
                            Users.pseudo
                    FROM $this->table, users
                    WHERE Comments.posts_id = '" . $id . "'
                    AND Comments.user_id = Users.id 
                    ORDER BY Comments.id DESC";
            // debug($req);
            $query = $this->connexion->prepare($req);
            $query->execute();
            return $query->fetchAll();
    }

    public function addComment(string $comment, int $posts_id, int $userId)
    {
        $req = ("INSERT INTO comments (comment, date_comment, validate, posts_id, user_id) VALUES (?, NOW(), '0', ?, ?)");
        $query = $this->connexion->prepare($req);
        $query->execute(array($comment, $posts_id, $userId));
    }

}