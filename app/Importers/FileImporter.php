<?php

namespace App\Importers;

abstract class FileImporter extends Importer
{
    protected $fileDir;

    public function __construct(protected string $fileName, protected string $dir)
    {
        $this->prepareFile();
    }

    public function getFileDir(){
        return $this->fileDir;
    }
    abstract protected function prepareFile();
}