<?php

namespace App\Exporters;

use App\Connections\DbConnection;
use App\Connections\SQLiteConnection;

class SqliteExporter extends SqlDbExporter
{
    public function __construct(SQLiteConnection $conn, string $tableName)
    {
        parent::__construct($conn, $tableName);
    }

    function initialize(array $header): void
    {
        $this->conn->createTable($this->tableName, $header);
    }

    function writeItem(array $item): void
    {
        $this->conn->insert($this->tableName, $item);
    }
}