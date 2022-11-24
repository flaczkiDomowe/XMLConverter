<?php

namespace App\Interfaces;

use App\Exporters\Exporter;

interface DealsWithXML
{
    public function convertXML(Exporter $exporter, string $elementName);
}