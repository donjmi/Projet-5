<?php
namespace Blog\Models;

class CommentsModel extends MainModel{

public function __construct()
{
    // Nous définissons la table par défaut de ce modèle
    $this->table = "comments";

    // Nous ouvrons la connexion à la base de données
    $this->getConnection();
}

public function flux(){
    return simplexml_load_file('https://www.subfactory.fr/xml/blog.xml');
    }
}