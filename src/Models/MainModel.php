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
        // $req = "SELECT DISTINCT * FROM ". $this->table ." ORDER BY id desc LIMIT 0,5" ;
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

    public function test($fields=null){
        if($fields==null){
            $fields = "*";
        }
        $req = "SELECT $fields FROM ". $this->table . " WHERE id='". $this->id ."'"; ;
        $data = $this->_connexion->prepare($req);
        $data->execute();
        return $data->fetchAll();
       
    }
    public function createData(array $data){
        $keys = implode(', ', array_keys($data));
        $values = implode('", "', $data);
        $req = 'INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES ("' . $values . '")';
        
        $query = $this->_connexion->prepare($req);
        return $query->execute();
    }

    public function updateData(string $value, array $data, string $key = null)
    {
        $set = null;

        foreach ($data as $dataKey => $dataValue) {
            $set .= $dataKey . ' = "' . $dataValue . '", ';
        }

        $set = substr_replace($set, '', -2);

        if (isset($key)) {
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE id = ?';
        }

        $this->database->setData($query, [$value]);
    }
    /**
     * Deletes Data from its id or another key
     * @param string $value
     * @param string|null $key
     */
    public function deleteData(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        }

        $this->database->setData($query, [$value]);
    }

}