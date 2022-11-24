<?php

namespace App\Factories;

use App\Connections\FtpConnection;
use App\Importers\FtpImporter;
use App\Importers\HttpImporter;
use App\Importers\LocalFileImporter;

class ImporterFactory
{
    public static function getLocalFileImporter(string $fileName, string $fileDirectory){
        return new LocalFileImporter($fileName, $fileDirectory);
    }

    public static function getFtpImporter(string $fileName, string $fileDirectory, FtpConnection $connection){
        return new FtpImporter($fileName, $fileDirectory, $connection);
    }

    public static function getHttpImporter(string $url)
    {
        return new HttpImporter($url);
    }

}