<?php

namespace Pa\Core;

use Pa\Core\Connection\BDDInterface;
use Pa\Core\Connection\PDOConnection;

class Manager
{
    private $table;
    protected $connection;
    protected $class;

    /**
     * Manager constructor.
     * @param string $class
     * @param string $table
     * @param BDDInterface|null $connection
     * Connexion à la bdd et récupère le nom de la table sur laquel les futurs requêtes seront joué
     */
    public function __construct(string $class, string $table, BDDInterface $connection = null)
    {
        $this->class = $class;
        $this->table =  DB_PREFIXE.$table;
        
        $this->connection = $connection;
        if(NULL === $connection)
            $this->connection = new PDOConnection();
    }

    /**
     * @param $objectToSave
     * Sauvegarde ou mise a jour des infos dans la bdd
     */
    public function save($objectToSave)
    {
        $objectArray =  $objectToSave->__toArray();
        $columnsData = array_values($objectArray);
        $columns = array_keys($objectArray);
        // On met 2 points devant chaque clé du tableau
        $params = array_combine(
            array_map(function($k){ return ':'.$k; }, array_keys($objectArray)),
            $objectArray
        );
        // Vérifie si il s'agit d'une mise a jour ou d'une insertion
        if (!is_numeric($objectToSave->getId())) {
            // Array shift pour enlevé la case id du tableau
            array_shift($columns);
            array_shift($params);
            //INSERT
            $sql = "INSERT INTO ".$this->table." (".implode(",", $columns).") VALUES (:".implode(",:", $columns).");";
        } else {

            //UPDATE
            foreach ($columns as $column) {
                $sqlUpdate[] = $column."=:".$column;
            }
            $sql = "UPDATE ".$this->table." SET ".implode(",", $sqlUpdate)." WHERE ".$columns[0]."=:".$columns[0];
        }
        $this->connection->query($sql, $params);
    }

    /**
     * @param int $id
     * @param string $tableId
     * @return Model|null
     * Recherche d'un élément par son id en bdd
     */
    public function find(int $id, string $tableId = 'id'): ?Model
    {
        $sql = "SELECT * FROM $this->table where ".$tableId ."= :".$tableId;

        $result = $this->connection->query($sql, [':'.$tableId => $id]);
        
        $row = $result->getOneOrNullResult();

        if ($row) {
            $object = new $this->class();
            return $object->hydrate($row);
        } else {
            return null;
        }
      
    }

    /**
     * @return array
     * Récupère toute les entrées d'une table
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM $this->table";
        $result = $this->connection->query($sql);
        $rows = $result->getArrayResult($this->class);

        return $rows;
    }

    /**
     * @param array $params
     * @param array|null $order
     * @return array
     * Recupère dans une tables les entrées selon les params
     */
    public function findBy(array $params, array $order = null): array
    {
        $results = array();

        $sql = "SELECT * FROM $this->table where ";

        foreach($params as $key => $value) {
            if(is_string($value))
                $comparator = 'LIKE';
            else 
                $comparator = '=';

            $sql .= " $key $comparator :$key and"; 
            $params[":$key"] = $value;
            unset($params[$key]);
        }

        $sql = rtrim($sql, 'and');

        if($order) {
            $sql .= "ORDER BY ". key($order). " ". $order[key($order)]; 
        }

        $result = $this->connection->query($sql, $params);
        $rows = $result->getArrayResult();

        return $rows;
    }

    /**
     * @param array $params
     * @return int
     *
     * Compte le nombre d'entrées qui correspond au params donné
     */
    public function count(array $params): int
    {
        $sql = "SELECT COUNT(*) FROM $this->table where ";

        foreach($params as $key => $value) {
            if(is_string($value))
                $comparator = 'LIKE';
            else 
                $comparator = '=';
            $sql .= " $key $comparator :$key and"; 

            $params[":$key"] = $value;
            unset($params[$key]);
        }

        $sql = rtrim($sql, 'and');

        $result = $this->connection->query($sql, $params);
        return $result->getValueResult();
    }

    /**
     * @param int $id
     * @param string $tableId
     * @return bool
     * Supprime en bdd un élément par son id
     */
    public function delete(int $id, string $tableId = 'id'): bool
    {
        $sql = "DELETE FROM $this->table where ".$tableId."=:".$tableId;
        $result = $this->connection->query($sql, [':'.$tableId => $id]);
        return true;
    }

    /**
     * @param $sql
     * @param null $parameters
     * @return mixed
     *
     * Execute la requête
     */
    protected function sql($sql, $parameters = null)
    {
        if ($parameters) {
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute($parameters);

            return $queryPrepared;
        } else {
            $queryPrepared = $this->pdo->prepare($sql);
            $queryPrepared->execute();

            return $queryPrepared;
        }
    }

    
    
}
