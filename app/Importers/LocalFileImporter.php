<?php

namespace App\Importers;

use Exception;

class LocalFileImporter extends FileImporter
{

    protected function prepareFile()
    {
        $this->fileDir=$this->dir . "/" . $this->fileName;
        if (!file_exists($this->fileDir)) {
            throw new Exception('File not found.');
        }
    }

}