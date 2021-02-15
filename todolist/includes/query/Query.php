<?php


abstract class Query {

    public function __construct(protected Connection $connection)
    {
    }

    public abstract function select(string $tablename, array $columns);

    public abstract function update(string $tablename, array $fields);

    public abstract function insert($tablename, $fields);
}