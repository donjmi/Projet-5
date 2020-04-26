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
            $req = "SELECT Comments.id,
                            Comments.user_id,
                            Comments.comment,
                            Comments.posts_id,
                            Comments.date_comment,
                            Users.pseudo
                    FROM Comments, users
                    WHERE Comments.posts_id = '" . $id . "'
                    AND Comments.user_id = Users.id 
                    ORDER BY Comments.id DESC";
            // debug($req);
            $query = $this->connexion->prepare($req);
            $query->execute();
            return $query->fetchAll();
    }
}