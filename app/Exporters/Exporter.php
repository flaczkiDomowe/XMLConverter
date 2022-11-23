<?php

namespace App\Exporters;

abstract class Exporter
{
    abstract function initialize(array $header):void;
    abstract function writeItem(array $item):void;

}