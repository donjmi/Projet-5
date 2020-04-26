<?php
namespace Blog\Models;

/**
 * ArticlesModel
 */
class UsersModel extends MainModel{
    public $id;

    public function __construct()
    {
        // Nous définissons la table par défaut de ce modèle
        $this->table = "users";

        // Nous ouvrons la connexion à la base de données
        $this->getConnection();
    }

    public function controlUser($pseudo, $email){
        $req = "SELECT * FROM $this->table WHERE pseudo = '" . $pseudo . "'
                    AND email = '" . $email . "'  
                    LIMIT 1 ";
            $query = $this->connexion->prepare($req);
            $query->execute();
            return $query->fetch();
    }

    public function controlEmail($email){
        $req = "SELECT * FROM $this->table WHERE email = '" . $email . "' 
                    LIMIT 1 ";
            $query = $this->connexion->prepare($req);
            $query->execute();
            return $query->fetch();
    }

    public function controlPseudo($pseudo){
        $req = "SELECT * FROM $this->table WHERE pseudo = '" . $pseudo . "' 
                    LIMIT 1 ";
            $query = $this->connexion->prepare($req);
            $query->execute();
            return $query->fetch();
    }

}