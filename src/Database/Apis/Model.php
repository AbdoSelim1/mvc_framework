<?php

namespace Src\Database\Apis;

class Model
{ 
    protected static $childModelName;

    public static function all(array|string $columns = '*')
    {
        app()->db->init();
        self::$childModelName = static::class;
        return app()->db->read($columns);
    }

    public static function select(array|string $columns = '*', array $filters = null)
    {
        app()->db->init();
        self::$childModelName = static::class;
        return app()->db->read($columns, $filters);
    }

    public static function update(array $data, ?array $filters = null)
    {
        app()->db->init();
        self::$childModelName = static::class;
        return app()->db->update($data, $filters);
    }

    public static function create(array $data)
    {
        app()->db->init();  
        self::$childModelName = static::class;
        return app()->db->create($data);
    }

    public static function delete(?array $filters = null)
    {
        app()->db->init();
        self::$childModelName = static::class;
        return app()->db->delete($filters);
    }

    public static function getTableName()
    {
        app()->db->init();
        return class_basename(self::$childModelName);
    }
}
