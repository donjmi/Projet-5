<?php
namespace Blog\Models;

class ArticlesModel extends MainModel{

public function __construct()
{
    // Nous définissons la table par défaut de ce modèle
    $this->table = "articles";

    // Nous ouvrons la connexion à la base de données
    $this->getConnection();
}

public function flux(){
    return simplexml_load_file('https://www.subfactory.fr/xml/blog.xml');
    }
}