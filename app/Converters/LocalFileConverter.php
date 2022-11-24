<?php

namespace App\Converters;

use App\Exporters\Exporter;
use App\Importers\LocalFileImporter;
use DOMDocument;
use XMLReader;

class LocalFileConverter extends FileConverter
{

    /**
     * @param LocalFileImporter $localFileImporter
     */
    function __construct(LocalFileImporter $localFileImporter)
    {
        parent::__construct($localFileImporter);

    }

    public function convertXML(Exporter $exporter, string $elementName)
    {

        $doc = new DOMDocument;
        $inputStream = XMLReader::open($this->importer->getFileDir());

        while ($inputStream->read() && $inputStream->name !== $elementName);

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