<?php

namespace App\Converters;

use App\Importers\FileImporter;
use JetBrains\PhpStorm\Pure;


abstract class FileConverter extends Converter
{
    #[Pure] public function __construct(FileImporter $importer)
    {
        parent::__construct($importer);
    }
}