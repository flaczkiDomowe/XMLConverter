#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';


use App\Commands\Fetch10Command;
use App\Commands\ImportXMLCommand;
use Symfony\Component\Console\Application;

define('RESOURCES_DIR',realpath(__DIR__.'/resources'));
ini_set("error_log", __DIR__."/log/php-error.log");
ini_set("log_errors", 1);

$application = new Application();

$application->add(new ImportXMLCommand());
$application->add(new Fetch10Command());

$application->run();