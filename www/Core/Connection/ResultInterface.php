<?php
namespace Pa\Core\Connection;

/**
 * Interface ResultInterface
 * @package PA\Core\Connection
 */
interface ResultInterface
{
    public function getArray();
    public function getOneOrNull():?array;
    public function getValue();
    public function getArrayResult(string $class = null): array;
}
