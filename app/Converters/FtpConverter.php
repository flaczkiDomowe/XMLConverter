<?php

namespace App\Converters;

use App\Exporters\Exporter;
use App\Importers\FtpImporter;
use DOMDocument;
use XMLReader;

class FtpConverter extends FileConverter
{

    const TEMPORARY_FILENAME = 'temporary_file';

    /**
     * @param FtpImporter $localFileImporter
     */
    function __construct(FtpImporter $ftpImporter)
    {
        parent::__construct($ftpImporter);

    }

    public function convertXML(Exporter $exporter, string $elementName)
    {

        $doc = new DOMDocument;
        $inputStream = XMLReader::open($this->importer->getFileDir());

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
            $exporter->writeItem(get_object_vars($node));
            $inputStream->next($elementName);
        }
        unlink(RESOURCES_DIR.'/'.self::TEMPORARY_FILENAME);
    }
}