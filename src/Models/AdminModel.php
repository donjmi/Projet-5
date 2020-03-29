<?php
namespace Blog\Models;

class AdminModel extends MainModel{
      
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        // table database
        $this->table = "articles";

        // get cnx
        $this->getConnection();
    }
}