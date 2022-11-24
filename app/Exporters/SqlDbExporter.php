<?php

namespace App\Exporters;

use App\Connections\DbConnection;
use App\Connections\SQLiteConnection;
use App\Factories\ExporterFactory;

class SqlDbExporter extends Exporter
{
    public function __construct(private DbConnection $conn)
    {
    }

    function initialize(array $header): void
    {
        // TODO: Implement initialize() method.
    }

    function writeItem(array $item): void
    {
        // TODO: Implement writeItem() method.
    }
}