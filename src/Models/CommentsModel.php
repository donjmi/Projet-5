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
}