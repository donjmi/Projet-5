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
     * @return void
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
    public function getAll(string $key=null, string $value=null)
    {
            $req = "SELECT DISTINCT * FROM " . $this->table;
            
            if (isset($key) && isset($value)){
                $req .= " WHERE $key = $value";
            }

            $req .= " ORDER BY id desc";
            $query = $this->connexion->prepare($req);
            $query->execute();
            return $query->fetchAll();
    }
    
    /**
     * Lists all Datas from the id or multiple key
     *
     * @param  mixed $params
     * @return void
     */
    public function listAll(array $params=null)
    {
            $req = 'SELECT DISTINCT * FROM ' . $this->table;
            
            if (isset($params)){
                foreach($params as $key => $value)
                {
                    $req .= ($key == key($params) ? " WHERE" : " AND");
                    $req .= ' '.$key.' = "'.$value.'"';
                }
            }
            $req .= " ORDER BY id desc";
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
   
    /**
     * createQuery : function to create or update entry
     *
     * @param  mixed $command
     * @param  mixed $data
     * @return void
     */
    public function createQuery(string $command, array $data)
    {
        $keys = implode(', ', array_keys($data));
        $values = implode('", "', $data);

        switch ($command) {
            case 'create':
                $req = 'INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES ("' . $values . '")';
                break;

            case 'update':
                $set = null;
                foreach ($data as $dataKey => $dataValue) {
                    if ($dataKey == 'id') {
                        continue;
                    }
                    $set .= $dataKey . ' = "' . $dataValue . '", ';
                }
                $set = substr_replace($set, '', -2);
                $req = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE id = ' . $data['id'];
                break;
        }

        $query = $this->connexion->prepare($req);
        return $query->execute();
    }
}
