<?php

namespace Blog\Models;

class CommentsModel extends MainModel
{
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
                            Comments.validate,
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
                $req = ("INSERT INTO $this->table (comment, date_comment, validate, posts_id, user_id) VALUES (?, NOW(), '0', ?, ?)");
                $query = $this->connexion->prepare($req);
                $query->execute(array($comment, $posts_id, $userId));
        }

        public function noValidate()
        {
                $req = ("SELECT * From $this->table WHERE validate = 0 ORDER BY id DESC");
                $query = $this->connexion->prepare($req);
                $query->execute();
                return $query->fetchAll();
        }
        public function notOkComment()
        {
                $req = "SELECT  Comments.id,
                            Comments.posts_id,
                            Comments.user_id,
                            Comments.comment,
                            Comments.date_comment,
                            Comments.validate,
                            articles.title
                    FROM $this->table, articles
                    WHERE Comments.posts_id = articles.id
                    AND validate = 0 
                    ORDER BY Comments.date_comment ASC";
                //     debug($req);
                $query = $this->connexion->prepare($req);
                $query->execute();
                return $query->fetchAll();
        }

        public function okComment($id)
        {
                $req = "SELECT  Comments.id,
                            Comments.posts_id,
                            Comments.user_id,
                            Comments.comment,
                            Comments.date_comment,
                            Comments.validate,
                            Users.pseudo
                    FROM $this->table, users
                    WHERE Comments.posts_id = '" . $id . "'
                    AND Comments.user_id = Users.id 
                    AND validate = 1 
                    ORDER BY Comments.id DESC";
                $query = $this->connexion->prepare($req);
                $query->execute();
                return $query->fetchAll();
        }

        /**
         * publish comment
         *
         * @param  mixed $id
         * @return void
         */
        public function publish($id)
        {
                $query = $this->connexion->prepare("UPDATE $this->table SET validate = 1 WHERE id = ? ");
                $query->execute(array($id));
        }

        public function countComments()
        {
                $query = $this->connexion->prepare("SELECT * FROM $this->table WHERE validate = 0 ");
                $query->execute();
                $total = $query->rowCount();
                return $total;
        }
}
