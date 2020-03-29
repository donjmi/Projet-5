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
}