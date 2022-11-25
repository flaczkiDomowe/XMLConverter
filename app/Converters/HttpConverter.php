<?php

namespace App\Converters;

use App\Exporters\Exporter;
use App\Importers\HttpImporter;
use DOMDocument;
use XMLReader;

class HttpConverter extends Converter
{

    /**
     * @param HttpImporter $httpImporter
     */
    function __construct(HttpImporter $httpImporter)
    {

        parent::__construct($httpImporter);

    }

    public function convertXML(Exporter $exporter, string $elementName)
    {

        $doc = new DOMDocument;
        $inputStream = XMLReader::open($this->importer->getUrl());

        while ($inputStream->read() && $inputStream->name !== $elementName) ;

        $header = null;
        $iterator=0;
        echo "Importing start".PHP_EOL;
        while ($inputStream->name === $elementName) {
            $iterator++;
            if($iterator%50==0){
                echo "Downloaded ".$iterator.' elements.'.PHP_EOL;
            }
            $node = simplexml_import_dom($doc->importNode($inputStream->expand(), true));
            if (!$header) {
                $exporter->initialize(array_keys(get_object_vars($node)));
                $header = true;
            }
            $exporter->writeItem(get_object_vars($node));
            $inputStream->next($elementName);
        }

    }
}