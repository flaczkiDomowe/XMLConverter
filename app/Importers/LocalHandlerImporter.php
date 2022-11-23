<?php

namespace App\Importers;

use Exception;

abstract class LocalHandlerImporter extends HandlerImporter
{
    public function __construct(protected string $fileName, protected string $directory)
    {
        if (!file_exists($this->directory . "/" . $fileName)) {
            throw new Exception('File not found.');
        }
    }
}