<?php

namespace App\Connections;

use App\Config;

class SQLiteConnection extends DbConnection
{
    public function __construct()
    {
        $dsn="sqlite:" . Config::SQLITE_PATH;
        parent::__construct($dsn,Config::SQLITE_GUEST_USERNAME,Config::SQLITE_GUEST_PASSWORD);
    }


    public function createTable(string $tableName, array $columns)
    {
        $sqlCommand = 'CREATE TABLE IF NOT EXISTS ' . $tableName . '(';
        foreach($columns as $value){
            $sqlCommand .= " ".$value." TEXT,";
        }
        $sqlCommand=substr($sqlCommand, 0, -1);
        $sqlCommand .= ")";
        $this->conn->exec($sqlCommand);
    }

    public function insert(string $table, array $array){
        $sqlCommand = 'INSERT INTO '.$table.' (';
        $secondPart ='VALUES (';
        foreach ($array as $col => $val){
            if ($col === array_key_last($array)) {
                $sqlCommand .= $col . ' ';
                $secondPart .= "'".$val."'" . ' ';
            } else {
                $sqlCommand .= $col . ', ';
                $secondPart .= "'".$val."'" . ', ';
            }
        }

        $sqlCommand.=') '.$secondPart.')';
        $this->conn->exec($sqlCommand);
    }

}