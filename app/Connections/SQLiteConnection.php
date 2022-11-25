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
        $sqlCommand = "CREATE TABLE IF NOT EXISTS '" . SqlUtils::sql_escape($tableName) . "' (";
        foreach($columns as $value){
            $sqlCommand .= " '".SqlUtils::sql_escape($value)."' TEXT,";
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
                $secondPart .= "?" . ' ';
            } else {
                $sqlCommand .= $col . ', ';
                $secondPart .= "?" . ', ';
            }
        }

        $sqlCommand.=') '.$secondPart.')';

        $stmt = $this->conn->prepare($sqlCommand);
        $stmt->execute(array_values($array));;
    }

}