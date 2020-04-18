<?php
namespace Blog\Models;

/**
 * ArticlesModel
 */
class InscriptionModel extends MainModel{
    public $id;

    public function __construct()
    {
        // Nous définissons la table par défaut de ce modèle
        $this->table = "users";

        // Nous ouvrons la connexion à la base de données
        $this->getConnection();
    }

}