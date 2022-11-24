#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use App\Commands\ImportXML;
use Symfony\Component\Console\Application;

define('RESOURCES_DIR',realpath(__DIR__.'/resources'));

$application = new Application();

$application->add(new ImportXML());

$application->run();