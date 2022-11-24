<?php

namespace App\Converters;

use App\Importers\Importer;
use App\Interfaces\DealsWithXML;

abstract class Converter implements DealsWithXML
{
    public function __construct(protected Importer $importer)
    {
    }
}