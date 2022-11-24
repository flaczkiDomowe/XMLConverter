<?php

namespace App\Connections;

use PDO;

abstract class DbConnection extends Connection
{

    protected function connect()
    {
        $this->conn = new PDO($this->address);
    }

    abstract public function createTable(string $tableName, array $columns);

}