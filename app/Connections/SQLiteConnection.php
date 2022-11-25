<?php

namespace App\Connections;

use App\Config;

class SQLiteConnection extends DbConnection
{
    public function __construct()
    {
        $dsn="sqlite:" . Config::SQLITE_PATH;
        var_dump($dsn);
        parent::__construct($dsn,Config::SQLITE_GUEST_USERNAME,Config::SQLITE_GUEST_PASSWORD);
    }


    public function createTable(string $tableName, array $columns)
    {
        $sqlCommand = 'CREATE TABLE IF NOT EXISTS ' . $tableName . '(';
        foreach($columns as $value){
            $sqlCommand .= " ".$value." TEXT";
        }
        $sqlCommand .= ")";
        $this->conn->exec($sqlCommand);
    }
}