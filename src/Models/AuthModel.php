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
    
    /**
     * verifyEmail
     *
     * @param  mixed $email
     * @return void
     */
    public function verifyEmail($email)
    {
        $req = "SELECT * FROM " . $this->table . " WHERE email='" . $email . "'";
        $query = $this->connexion->prepare($req);
        $query->execute();
        return $query->fetch();
    }
    
    /**
     * verifytoken
     *
     * @param  mixed $id
     * @return void
     */
    public function verifytoken($id)
    {
        $req = "SELECT * FROM " . $this->table . " WHERE id = $id ";
        $query = $this->connexion->prepare($req);
        $query->execute();
        return $query->fetch();
    }

        
    /**
     * confirmAuth
     *
     * @param  mixed $id
     * @return void
     */
    public function confirmAuth($id)
    {
            $query = $this->connexion->prepare("UPDATE $this->table SET validate = 1, token = '' WHERE id = ? ");
            $query->execute(array($id));
    }

}