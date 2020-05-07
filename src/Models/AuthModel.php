<?php
namespace Blog\Models;

/**
 * ArticlesModel
 */
class AuthModel extends MainModel{
    public $id;

    public function __construct()
    {
        // Nous définissons la table par défaut de ce modèle
        $this->table = "users";

        // Nous ouvrons la connexion à la base de données
        $this->getConnection();
    }

    public function getPass($email)
    {
        $req = "SELECT * FROM " . $this->table . " WHERE email='" . $email . "'";
        $query = $this->connexion->prepare($req);
        $query->execute();
        return $query->fetch();
    }

}