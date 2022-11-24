<?php

namespace App\Importers;

class HttpImporter extends DirectDataImporter
{
    public function __construct(private string $url)
    {
    }

    public function getUrl(){
        return $this->url;
    }
}