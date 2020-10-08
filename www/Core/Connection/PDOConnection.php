<?php

namespace Pa\Core\Connection;

/**
 * Class PDOConnection
 * @package Pa\Core\Connection
 */
class PDOConnection implements BDDInterface
{

    protected $pdo;

    /**
     * PDOConnection constructor.
     * Connection a la base de données
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * Try & catch pour se connecter. Utilisation des variable d'environnement pour la connexion a la bdd
     */
    public function connect()
    {
        try {
            $this->pdo = new \PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PWD);
        } catch (\Throwable $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }

    /**
     * @param string $query
     * @param array|null $parameters
     * @return PDOResult
     * Execute la requete sql
     */
    public function query(string $query, array $parameters = null)
    {
        $queryPrepared = $this->pdo->prepare($query);
        $parameters !== null ? $queryPrepared->execute($parameters) : $queryPrepared->execute();
        return new PDOResult($queryPrepared);
    }
}
