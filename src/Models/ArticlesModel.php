<?php
namespace Blog\Models;

/**
 * ArticlesModel
 */
class ArticlesModel extends MainModel{

    public function __construct()
    {
        // table database
        $this->table = "articles";

        // get cnx
        $this->getConnection();
    }
    
    /**
     * flux rss"http://feeds.feedburner.com/thetvaddict/AXob"  
     *
     * @return void 
     */
    public function flux(){
        return simplexml_load_file('http://www.critictoo.com/feed/');
        // return simplexml_load_file('https://www.cineserie.com/feed/');
        }
        
        /**
         * getArticles
         *
         * @return void
         */
        public function getArticles()
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
                    ORDER BY articles.id DESC";
            // debug($req);
            $query = $this->connexion->prepare($req);
            $query->execute();
            return $query->fetchAll();
    }
    
    /**
     * getOneArticle
     *
     * @param  mixed $id
     * @return void
     */
    public function getOneArticle($id)
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
                    FROM articles, users
                    WHERE articles.id = '" . $id . "'
                    AND articles.user_id = users.id
                    AND articles.posted = 1
                    ORDER BY articles.id DESC";
        $query = $this->connexion->prepare($req);
        $query->execute();
        return $query->fetch();
    }

        
        /**
         * posted article
         *
         * @param  mixed $id
         * @return void
         */
        public function posted($id)
        {
                $query = $this->connexion->prepare("UPDATE $this->table SET posted = 1  WHERE id = ? ");
                $query->execute(array($id));
        }
        
        /**
         * countNoArticles articles not posted
         *
         * @return void
         */
        public function countNoArticles()
        {
                $query = $this->connexion->prepare("SELECT * FROM $this->table WHERE posted = 0 ");
                $query->execute();
                $total = $query->rowCount();
                return $total;
        }
}