<?php

namespace App\Converters;

use App\Exporters\Exporter;
use App\Importers\LocalFileImporter;
use DOMDocument;
use Exception;
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
        if(!$inputStream){
            throw new Exception('Failed to open file');
        }
        while ($inputStream->read() && $inputStream->name !== $elementName);

        $header = null;
        echo "Importing start".PHP_EOL;
        $iterator=0;
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
            try {
                $exporter->writeItem(get_object_vars($node));
            } catch (Exception $exception){
                error_log($exception->getMessage());
            }
            $inputStream->next($elementName);
        }
    }
}