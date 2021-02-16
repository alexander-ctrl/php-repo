<?php


abstract class Query {

    public function __construct(protected Connection $connection)
    {
    }

    public abstract function select(string $tablename, array $fields=[]);

    public abstract function update(string $tablename, array $fields, int $id);

    public abstract function insert($tablename, $fields);

    public abstract function delete(string $tablename, array $fields);

    public abstract function getById($tablename, $columns = [], int $id);
}