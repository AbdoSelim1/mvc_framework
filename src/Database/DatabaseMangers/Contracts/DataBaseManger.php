<?php

namespace Src\Database\DatabaseMangers\Contracts;

interface DataBaseManger
{
    public function connect(): \PDO;
    public function raw(string $query, array $values = []);
    public function create(array $data);
    public function read(array|string $columns = '*', ?array $filters = null);
    public function update(array $data, ?array $filters = null);
    public function delete(?array $filters = null);
}
