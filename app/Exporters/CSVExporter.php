<?php

namespace App\Exporters;

use Exception;

class CSVExporter extends Exporter
{

    private $outputFileStream;

    public function __construct(private string $filename,private string $directory, private string $separator)
    {

        if(!str_contains($filename, '.csv')){
            $this->filename .= '.csv';
        }

        $this->outputFileStream = fopen($this->directory . '/' . $this->filename, 'w');
        if (!$this->outputFileStream) {
            throw new Exception('File open failed.');
        }

    }

    public function __destruct()
    {
        fclose($this->outputFileStream);
    }

    public function initialize(array $header): void
    {
        fputcsv($this->outputFileStream, $header,$this->separator);
    }

    public function writeItem(array $item): void
    {
        fputcsv($this->outputFileStream,$item,$this->separator);
    }

}