<?php

namespace Src\Database\DatabaseGerammers\Contracts;

interface DataBaseGerammer
{
    function buildInsterQuery(array $columns): string;
    function buildUpdateQuery(array $columns, array|null $filters = null): string;
    function bulidDeleteQuery(array|null $filters = null): string;
    function buildSelectQuery(array|string $columns = "*", array|null $filters = null): string;
    function buildWhereQuery(string $query, array $filters): string;
}
