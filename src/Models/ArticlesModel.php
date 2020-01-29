<?php
namespace Blog\Models;

class ArticlesModel extends MainModel{

public function __construct()
{
    // Nous définissons la table par défaut de ce modèle
    $this->table = "posts";

    // Nous ouvrons la connexion à la base de données
    $this->getConnection();
}

public function getOne($id){
    $req = "SELECT * FROM ". $this->table ." WHERE id='". $id ."'";
    // $req = "SELECT * FROM ". $this->table ." WHERE id='10'";
    $query = $this->_connexion->prepare($req);
    $query->execute();
    return $query->fetch();
}
}