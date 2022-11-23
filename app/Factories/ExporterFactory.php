<?php

use App\Exporters\CSVExporter;

class ExporterFactory
{
    public function createCSVExporter(string $filename,string $directory = RESOURCES_DIR, string $separator = ';'): CSVExporter
    {
        try {
            $exporter = new CSVExporter($filename, $directory, $separator);
        } catch (Exception $e){
            die("Problem occured during CSV file creation");
        }
        return $exporter;
    }
}