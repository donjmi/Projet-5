<?php
namespace Blog\Models;

abstract class MainModel{

    // Propriété qui contiendra l'instance de la connexion
    protected $_connexion;

    // Propriétés permettant de personnaliser les requêtes
    public $table;
    public $id;

    /**
     * Fonction d'initialisation de la base de données
     *
     * @return void
     */
    public function getConnection(){
        // On supprime la connexion précédente
        $this->_connexion = null;
        
        require_once './../config/config.php';     

        // On essaie de se connecter à la base
        if ($this->_connexion === null){
            $this->_connexion = new \PDO(DB_DSN, DB_USER, DB_PASS, DB_OPTIONS);
        }
            return $this->_connexion;
    }   

    public function getAll(){
        $req = "SELECT DISTINCT * FROM ". $this->table ." ORDER BY id desc LIMIT 0,5" ;
        $query = $this->_connexion->prepare($req);
        $query->execute();
        return $query->fetchAll();
    }

    public function getOne(){
        $req = "SELECT * FROM ". $this->table ."WHERE id=" .$this->id;
        $query = $this->_connexion->prepare($req);
        $query->execute();
        return $query->fetch();
    }
}