<?php

namespace Src\Database\DatabaseMangers;

use Src\Database\DatabaseGerammers\MYSQLGerammer;
use Src\Database\DatabaseMangers\Contracts\DataBaseManger;

class MYSQLManger implements DataBaseManger
{
    private static $instance = null;


    public function __construct(private MYSQLGerammer $gerammer)
    {
    }

    public function connect(): \PDO
    {
        if (is_null(self::$instance)) {
            self::$instance = new \PDO("mysql:host=localhost;dbname=mvc", "root", '');
        }

        return self::$instance;
    }

    public function raw(string $query, array $values = [])
    {
        $stmt = self::$instance->prepare($query);
        foreach ($values as $index => $value) {
            $stmt->bindValue($index + 1, $value);
        }
        $return = $stmt->execute();
        if (str_starts_with(strtolower($query), 'select')) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $return;
    }

    public function create(array $data)
    {
    
        $query = $this->gerammer->buildInsterQuery(array_keys($data));
        $stmt = self::$instance->prepare($query);
        return $stmt->execute($data); // true , false
    }

    public function read(array|string $columns = '*', ?array $filters = null)
    {
        $query = $this->gerammer->buildSelectQuery($columns, $filters);
        $stmt = self::$instance->prepare($query);
        if ($filters) {
            $this->filter($stmt, $filters);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update(array $data, ?array $filters = null)
    {
        $query = $this->gerammer->buildUpdateQuery(array_keys($data), $filters);
        $stmt = self::$instance->prepare($query);
        foreach (array_values($data) as $index => $value) {
            $stmt->bindValue($index + 1, $value); // 1 , 2
        }

        if ($filters) {
            $this->filter($stmt, $filters, count($data));
        }
        return $stmt->execute();
    }

    public function delete(?array $filters = null)
    {
        $query = $this->gerammer->bulidDeleteQuery($filters);
        $stmt = self::$instance->prepare($query);
        if ($filters) {
            $this->filter($stmt, $filters);
        }
        return $stmt->execute();
    }

    private function filter($stmt, array $filters, $startBindingIndex = 0)
    {
        if (is_array($filters[0])) {
            foreach ($filters as $index => $filter) {
                $stmt->bindValue($index + $startBindingIndex + 1, $filter[2]);
            }
        } else {
            $stmt->bindValue(1 + $startBindingIndex, $filters[2]);
        }
    }
}
