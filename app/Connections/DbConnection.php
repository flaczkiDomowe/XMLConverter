<?php

namespace App\Connections;

use Exception;
use PDO;

abstract class DbConnection extends Connection
{

    protected function connect()
    {
        $this->conn = new PDO($this->address);
        if(!$this->conn){
            throw new Exception('Failed to create connection with database');
        }
    }

    abstract public function createTable(string $tableName, array $columns);

}