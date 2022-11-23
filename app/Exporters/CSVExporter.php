<?php

namespace App\Exporters;

use Exception;

class CSVExporter extends Exporter
{

    private $outputFileStream;

    public function __construct(private string $filename,private string $directory, private string $separator)
    {

        $this->outputFileStream = fopen(RESOURCES_DIR . '/' . $this->filename, 'w');

        if (!$this->outputFileStream) {
            throw new Exception('File open failed.');
            // log file open failed
        }

        //log file open success
    }

    public function __destruct()
    {
        fclose($this->outputFileStream);
        // log file closed
    }

    public function initialize(array $header): void
    {
        fputcsv($this->outputFileStream, $header);
        //header written
    }

    public function writeItem(array $item): void
    {
        fputcsv($this->outputFileStream,$item);
        //item written
    }

}