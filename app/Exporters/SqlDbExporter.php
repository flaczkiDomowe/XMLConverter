<?php

namespace App\Exporters;

use App\Connections\DbConnection;
use App\Connections\SQLiteConnection;
use App\Factories\ExporterFactory;

abstract class SqlDbExporter extends Exporter
{
    public function __construct(private DbConnection $conn, string $tableName)
    {
    }
}