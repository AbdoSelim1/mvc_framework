<?php

namespace Src\Database\DatabaseGerammers;

use Src\Database\Apis\Model;
use Src\Database\DatabaseGerammers\Contracts\DataBaseGerammer;

class MYSQLGerammer implements DataBaseGerammer
{
    public function buildInsterQuery(array $columns): string
    {
        $tableName = Model::getTableName();
        $query = "INSERT INTO `{$tableName}`( `" . implode("`,`", $columns) .  "`) VALUES( :" . implode(" ,:", $columns) .  ")";
        return $query;
    }

    public function buildUpdateQuery(array $columns, array $filters = null): string
    {
        $tableName = Model::getTableName();
        $query = "UPDATE `{$tableName}` SET " . implode(" = ?, ", $columns) . " = ? ";
        if ($filters) {
            return $this->buildWhereQuery($query, $filters);
        }
        return $query;
    }


    public function bulidDeleteQuery(array|null $filters = null): string
    {
        $tableName = Model::getTableName();
        $query = "DELETE FROM `{$tableName}`";
        if ($filters) {
            return $this->buildWhereQuery($query, $filters);
        }
        return $query;
    }


    public function buildSelectQuery(array|string $columns = "*", array|null $filters = null): string
    {
        $query = "SELECT ";
        if (is_array($columns)) {
            $query .= "`" . implode("`,`", $columns) . "`";
        } else {
            $query .= $columns;
        }
        $tableName = Model::getTableName();
        
        $query .= " FROM `{$tableName}`";
        if ($filters) {
            return $this->buildWhereQuery($query, $filters);
        }
        return $query;
    }


    public function buildWhereQuery(string $query, array $filters): string
    {
        $where = "WHERE ";
        if (is_array($filters[0])) {
            $count = count($filters) - 1;
            foreach ($filters as $index => $filter) {
                $where .= $filter[0] . " " . $filter[1] . " ? ";
                if ($count != $index) {
                    $where .= "AND ";
                }
            }
        } else {
            $where .= $filters[0] . " " . $filters[1] . " ? ";
        }
        return $query . " " .  $where;
    }
}
