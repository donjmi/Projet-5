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
     * flux rss
     *
     * @return void
     */
    public function flux(){
        return simplexml_load_file('https://www.cineserie.com/feed/');
        }
}