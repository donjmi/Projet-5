<?php
namespace Blog\Models;

class AdminModel extends MainModel{
      
public function __construct()
{
    // Nous définissons la table par défaut de ce modèle
    $this->table = "posts";
    // $this->id = "9";

    // Nous ouvrons la connexion à la base de données
    $this->getConnection();
}

}