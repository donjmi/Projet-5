<?php
namespace Blog\Models;

/**
 * class HomeModel
 */
class HomeModel extends MainModel{

    /**
    * Model constructor
    * Receives the Database Object & creates the Table Name
    */
    public function __construct()
    {
        // table database
        $this->table = "articles";

        // get cnx
        $this->getConnection();
    }

    /**
     * Lists all Datas from the id or another key with Limit
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function getLimit()
    {
        $req = "SELECT articles.id,
                    articles.title,
                    articles.slug,
                    articles.content,
                    articles.date_creation,
                    articles.url_images,
                    articles.update_article,
                    articles.posted,
                    Users.pseudo
            FROM articles
            INNER JOIN users
            ON articles.user_id = users.id
            WHERE articles.posted = 1
            ORDER BY articles.id DESC
            LIMIT 5";
            $query = $this->connexion->prepare($req);
            $query->execute();
            return $query->fetchAll();
    }
}