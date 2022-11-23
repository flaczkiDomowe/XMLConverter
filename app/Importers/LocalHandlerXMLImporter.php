<?php

namespace App\Importers;

use Exception;
use XMLReader;

class LocalHandlerXMLImporter extends LocalHandlerImporter
{

    function import()
    {
        $xmlReader=XMLReader::open($this->directory."/".$this->fileName);

        if ($xmlReader) {
            throw new Exception('XML local file open operation failed.');
            // log file open failed
        }

        return $xmlReader;
    }
}