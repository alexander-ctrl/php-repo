<?php

abstract class Sql {

    public function __construct(protected string $tablename, protected array $columns = array())
    {
    }

    abstract public function generate(): string;
}
