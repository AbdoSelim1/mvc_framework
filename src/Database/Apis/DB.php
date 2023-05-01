<?php
namespace Src\Database\Apis;


use Src\Database\Concerns\ConnectTo;
use Src\Database\DatabaseMangers\Contracts\DataBaseManger;

class DB
{

    public function __construct(public DataBaseManger $databaseManger)
    {
        
    }

    public function init()
    {
        ConnectTo::connect($this->databaseManger);
    }

    public function create(array $data)
    {
        return $this->databaseManger->create($data);
    }
    public function raw(string $query, array $values = [])
    {
        return $this->databaseManger->raw($query, $values);
    }
    public function read(array|string $columns = '*', $filters = null)
    {
        return $this->databaseManger->read($columns, $filters);
    }
    public function update(array $data, $filters = null)
    {

        return $this->databaseManger->update($data, $filters);
    }
    public function delete($filters = null)
    {
        return $this->databaseManger->delete($filters);
    }
}
