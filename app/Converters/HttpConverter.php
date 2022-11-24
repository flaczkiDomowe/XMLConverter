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

        while ($inputStream->name === $elementName) {
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