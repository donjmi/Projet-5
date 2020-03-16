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
        
        require_once '../config/config.php';     

        // On essaie de se connecter à la base
        if ($this->_connexion === null){
            $this->_connexion = new \PDO(DB_DSN, DB_USER, DB_PASS, DB_OPTIONS);
        }
            return $this->_connexion;
    }   

    public function getAll(){
        $req = "SELECT DISTINCT * FROM ". $this->table ." ORDER BY id desc" ;
        $query = $this->_connexion->prepare($req);
        $query->execute();
        return $query->fetchAll();
    }

    public function getOne($id){
        $req = "SELECT * FROM ". $this->table ." WHERE id='". $id ."'";
        $query = $this->_connexion->prepare($req);
        $query->execute();
        return $query->fetch();
        }

    public function createQuery(string $command, array $data){
        $keys = implode(', ', array_keys($data));
        $values = implode('", "', $data);

        switch($command){
            case 'insert':
                $req = 'INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES ("' . $values . '")';
            break;

            case 'update':
                $set = null;
                foreach ($data as $dataKey => $dataValue) {
                    if ($dataKey == 'id'){
                        continue;
                    }
                    $set .= $dataKey . ' = "' . $dataValue . '", ';
                }
                $set = substr_replace($set, '', -2);
                $req = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE id = '. $data['id'];
            break;

            case 'delete':
                $req = 'DELETE FROM ' . $this->table . ' WHERE id = '. $data['id'];
            break;
        }
        
        // debug($req);
        $query = $this->_connexion->prepare($req);
        return $query->execute();

        header('Location: index.php/Admin/edit');
    }

}