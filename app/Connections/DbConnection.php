<?php

namespace App\Connections;

use PDO;

class DbConnection extends Connection
{

    protected function connect()
    {
        $this->conn = new PDO($this->address);
    }

}