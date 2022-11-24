<?php

namespace App\Factories;

use App\Importers\LocalFileImporter;

class ImporterFactory
{
    public static function getLocalFileImporter($fileName, $fileDirectory){
        return new LocalFileImporter($fileName, $fileDirectory);
    }
}