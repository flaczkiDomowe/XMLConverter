<?php

namespace App\Factories;

use App\Converters\LocalFileConverter;

class ConverterFactory
{
    public static function getLocalFileConverter($fileName, $originDirectory)
    {

        $importer=ImporterFactory::getLocalFileImporter($fileName, $originDirectory);

        return new LocalFileConverter($importer);
    }
}