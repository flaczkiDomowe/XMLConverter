<?php

namespace App\Factories;

use App\Connections\FtpConnection;
use App\Importers\FtpImporter;
use App\Importers\HttpImporter;
use App\Importers\LocalFileImporter;
use Exception;

class ImporterFactory
{
    public static function getLocalFileImporter(string $fileName, string $fileDirectory){
        try {
            $importer = new LocalFileImporter($fileName, $fileDirectory);
        } catch (Exception $e){
            error_log($e->getMessage());
            die($e->getMessage());
        }
        return $importer;
    }

    public static function getFtpImporter(string $fileName, string $fileDirectory, FtpConnection $connection){
        try {
            $importer = new FtpImporter($fileName, $fileDirectory, $connection);
        } catch (Exception $e){
            error_log($e->getMessage());
            die($e->getMessage());
        }
        return $importer;
    }

    public static function getHttpImporter(string $url)
    {
        return new HttpImporter($url);
    }

}