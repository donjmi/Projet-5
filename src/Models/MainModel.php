<?php

namespace Blog\Models;
/**
 * MainModel
 * Receives the Database Object & creates the Table Name
 */
abstract class MainModel
{
    // Propriétés permettant de personnaliser les requêtes
    protected $table;
    public $model;
  
       /**
     * Allows to load a model
     * @param string $model
     */
    public static function loadModel(string $model)
    {
        // create an instance of this model
        $model = 'Blog\\Models\\' . $model . 'Model';
        return new $model();
    }

    /**
     * Fonction d'initialisation de la base de données
     *
     * @return void
     */
    public function getConnection()
    {
        // re-init data cnx
        $this->connexion = null;

        require_once '../config/config.php';

        // data cnx
        if ($this->connexion === null) {
            $this->connexion = new \PDO(DB_DSN, DB_USER, DB_PASS, DB_OPTIONS);
        }
        return $this->connexion;
    }
    
    /**
     * Lists all Datas from the id or another key
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function getAll(string $key=null, string $value=null, string $operator='=')
    {
            $req = "SELECT  * FROM " . $this->table;
            
            if (isset($key) && isset($value)){
                $req .= " WHERE $key $operator '$value'";
            }

            $req .= " ORDER BY id desc";
            //debug($req);
            $query = $this->connexion->prepare($req);
            $query->execute();
            return $query->fetchAll();
    } 
    
    /**
     * Reads Data from its id or another key
     *
     * @param  mixed $id
     * @return void
     */
    public function getOne($id)
    {
        $req = "SELECT * FROM " . $this->table . " WHERE id='" . $id . "'";
        $query = $this->connexion->prepare($req);
        $query->execute();
        return $query->fetch();
    }
    
    /**
     * Delete entry
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        $req = 'DELETE FROM ' . $this->table . ' WHERE id=' . $id;
        $query = $this->connexion->prepare($req);
        return $query->execute();
    }

    public function create(array $data)
    {
        $keys = implode(', ', array_keys($data));
        $values = implode('", "', $data);
        $req = 'INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES ("' . $values . '")';      
        $query = $this->connexion->prepare($req);
        return $query->execute();
    }

    public function update(array $data)
    {
        $keys = implode(', ', array_keys($data));
        $values = implode('", "', $data);
        $set = null;
            foreach ($data as $dataKey => $dataValue) {
                if ($dataKey == 'id'){
                        continue;
                }
                $set .= $dataKey . ' = "' . $dataValue . '", ';
                }
                $set = substr_replace($set, '', -2);
                $req = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE id = '. $data['id'];
        $query = $this->connexion->prepare($req);
        return $query->execute();
    }
}
