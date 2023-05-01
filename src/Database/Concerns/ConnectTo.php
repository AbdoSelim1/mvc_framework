<?php

namespace Src\Database\Concerns;

use Src\Database\DatabaseMangers\Contracts\DataBaseManger;

class ConnectTo
{
    public static function connect(DataBaseManger $dataBaseManger)
    {
        return $dataBaseManger->connect();
    }
}
