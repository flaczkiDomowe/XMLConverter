<?php

namespace App\Factories;

use App\Converters\FtpConverter;
use App\Converters\HttpConverter;
use App\Converters\LocalFileConverter;

class ConverterFactory
{
    public static function getLocalFileConverter($fileName, $originDirectory)
    {

        $importer=ImporterFactory::getLocalFileImporter($fileName, $originDirectory);

        return new LocalFileConverter($importer);
    }

    public static function getFtpConverter($fileName, $originDirectory, $address ,$username, $password){

        $ftpConn = ConnectionFactory::getFtpConnection($address,$username,$password);
        $importer = ImporterFactory::getFtpImporter($fileName,$originDirectory,$ftpConn);

        return new FtpConverter($importer);
    }

    //moznaby wzbogacic o identyfikacje
    public static function getHttpConverter($url){

        $importer = ImporterFactory::getHttpImporter($url);

        return new HttpConverter($importer);

    }

}