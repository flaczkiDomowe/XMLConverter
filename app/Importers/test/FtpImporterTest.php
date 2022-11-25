<?php

namespace App\Importers\test;

use App\Converters\FtpConverter;
use App\Factories\ConnectionFactory;
use App\Factories\ImporterFactory;
use Exception;
use PHPUnit\Framework\TestCase;

class FtpImporterTest extends TestCase
{

    public function test__construct()
    {
        self::expectError();
        define('RESOURCES_DIR',realpath(__DIR__.'/resources'));
        try {
            unlink(RESOURCES_DIR . '/' . FtpConverter::TEMPORARY_FILENAME);
        } catch(Exception $e){}
        self::assertFalse(file_exists(RESOURCES_DIR.'/'.FtpConverter::TEMPORARY_FILENAME));
        $ftp=ConnectionFactory::getFtpConnection('test.rebex.net','demo','password');
        ImporterFactory::getFtpImporter('readme.txt','/pub/example',$ftp);
        self::assertTrue(file_exists(RESOURCES_DIR.'/'.FtpConverter::TEMPORARY_FILENAME));
    }
}
