<?php

namespace App\Factories;

use App\Connections\SQLiteConnection;
use App\Exporters\CSVExporter;
use App\Exporters\SqlDbExporter;
use App\Exporters\SqliteExporter;
use Exception;

class ExporterFactory
{
    const DEFAULT_SEPARATOR = ';';
    const DEFAULT_NAME = 'defaultName';

    public static function getCSVExporter(string $outputFileName, string $directory, string $separator): CSVExporter
    {
        try {
            $exporter = new CSVExporter($outputFileName, $directory, $separator);
        } catch (Exception $e){
            die("Problem occured during CSV file creation");
        }
        return $exporter;
    }

    public static function getSqliteExporter(string $itemName)
    {
        $sqliteConnection = new SQLiteConnection();
        $exporter = new SqliteExporter($sqliteConnection ,$itemName);
        return $exporter;
    }
}