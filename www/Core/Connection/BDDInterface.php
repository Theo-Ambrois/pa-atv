<?php

namespace Pa\Core\Connection;
/**
 * Interface BDDInterface
 * @package PA\Core\Connection
 */
interface BDDInterface
{
    public function connect();

    public function query(string $query, array $params = null);
}
