<?php

namespace App\Factories;

use App\Importers\LocalHandlerXMLImporter;

class XMLHandlerFactory
{
    public static function getLocalFileXMLStream($filename, $directory = RESOURCES_DIR){

        $xmlImporter = new LocalHandlerXMLImporter($filename,$directory);
        return $xmlImporter->import();


    }
}