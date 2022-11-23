<?php

namespace App\Services;

use App\Factories\XMLHandlerFactory;
use DOMDocument;
use XMLReader;

class XMLConverterService
{

    public function convert(){

        switch($origin){
            case "local":
                XMLHandlerFactory::getLocalFileXMLStream($inputFileName, $directory);
        }

        $outputFile=fopen(RESOURCES_DIR."/name.csv",'w');

        $doc = new DOMDocument;

        while ($z->read() && $z->name !== 'item');

        $header = null;

        while ($z->name === 'item') {
            $node = simplexml_import_dom($doc->importNode($z->expand(), true));
            if (!$header) {
                fputcsv($outputFile, array_keys(get_object_vars($node)));
                $header = true;
            }
            fputcsv($outputFile, get_object_vars($node), ';');
            $z->next('item');
        }
    }
}