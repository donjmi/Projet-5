<?php

namespace Blog\Models;
abstract class MainModel
{
    // Propriétés permettant de personnaliser les requêtes
    protected $table;
  
    /**
     * Fonction d'initialisation de la base de données
     *
     * @return void
     */
    public function getConnection()
    {
        // On supprime la connexion précédente
        $this->connexion = null;

        require_once '../config/config.php';

        // On essaie de se connecter à la base
        if ($this->connexion === null) {
            $this->connexion = new \PDO(DB_DSN, DB_USER, DB_PASS, DB_OPTIONS);
        }
        return $this->connexion;
    }
  
    public function getAll()
    {
        $req = "SELECT DISTINCT * FROM " . $this->table . " ORDER BY id desc";
        $query = $this->connexion->prepare($req);
        $query->execute();
        return $query->fetchAll();
    }

    public function getOne($id)
    {
        $req = "SELECT * FROM " . $this->table . " WHERE id='" . $id . "'";
        $query = $this->connexion->prepare($req);
        $query->execute();
        return $query->fetch();
    }

    public function delete($id)
    {
        $req = 'DELETE FROM ' . $this->table . ' WHERE id=' . $id;
        $query = $this->connexion->prepare($req);
        return $query->execute();
    }

     /**
     * Creates a new Data entry
     * @param array $data
     */
    public function createData(array $data)
    {
        $keys = implode(', ', array_keys($data));
        $values = implode('", "', $data);
        $req = 'INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES ("' . $values . '")';
        $query = $this->connexion->prepare($req);
        return $query->execute();
    }

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
