<?php

namespace Pa\Core;

use PA\Core\Connection\BDDInterface;
use Pa\Core\Connection\PDOConnection;
use Pa\Core\Connection\ResultInterface;


class QueryBuilder
{

    protected $connection;
    protected $query;
    protected $parameters;
    protected $alias;

    /**
     * QueryBuilder constructor.
     * @param BDDInterface|null $connection
     */
    public function __construct(BDDInterface $connection = NULL)
    {
        $this->connection = $connection;
        if (NULL === $connection) {
            $this->connection = new PDOConnection();
        }

        $this->query = "";
        $this->parameters = [];
    }

    /**
     * @param string $values
     * @return $this
     */
    public function select(string $values = '*'): QueryBuilder
    {
        $this->addToQuery("SELECT $values");

        return $this;
    }

    public function count(string $values = '*')
    {
        $this->addToQuery("SELECT COUNT(".$values.")");

        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @return $this
     */
    public function from(string $table, string $alias): QueryBuilder
    {
        $this->addToQuery("FROM ".DB_PREFIXE."$table $alias");
        $this->alias = $alias;

        return $this;
    }

    /**
     * @param string $conditions
     * @return $this
     */
    public function where(string $conditions): QueryBuilder
    {
        $this->addToQuery("WHERE $conditions");

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setParameter(string $key, string $value): QueryBuilder
    {
        $this->parameters[":$key"] = $value;

        return $this;
    }

    /**
     * @param string $table
     * @param string $aliasTarget
     * @param string $aliasSource
     * @param string $fieldSource
     * @param string $fieldTarget
     * @return $this
     */
    public function join(string $table, string $aliasTarget, string $aliasSource ,string $fieldSource = 'id', string $fieldTarget = 'id'): QueryBuilder
    {

        $this->addToQuery("JOIN ".DB_PREFIXE."$table $aliasTarget ON $aliasTarget.$fieldTarget = $aliasSource.$fieldSource");

        return $this;
    }

    /**
     * @param string $table
     * @param string $aliasTarget
     * @param string $fieldSource
     * @param string $fieldTarget
     * @return $this
     */
    public function leftJoin(string $table, string $aliasTarget, string $fieldSource = 'id', string $fieldTarget = 'id'): QueryBuilder
    {
        $aliasSource = $this->alias;

        $this->addToQuery("LEFT JOIN ".DB_PREFIXE."$table $aliasTarget ON $aliasTarget.$fieldTarget = $aliasSource.$fieldSource");

        return $this;
    }

    /**
     * @param string $query
     * @return $this
     */
    public function addToQuery(string $query): QueryBuilder
    {
        $this->query .= $query . " ";

        return $this;
    }

    /**
     * @return ResultInterface
     */
    public function getQuery(): ResultInterface
    {
        $result = $this->connection->query($this->query, $this->parameters);

        return $result;

    }
}
