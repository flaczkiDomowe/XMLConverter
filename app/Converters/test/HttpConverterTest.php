<?php

namespace App\Converters\test;

use App\Config;
use App\Factories\ConverterFactory;
use App\Factories\ExporterFactory;
use PHPUnit\Framework\TestCase;

class HttpConverterTest extends TestCase
{

    public function testConvertXML()
    {
        define('RESOURCES_DIR',realpath(__DIR__.'/resources'));
        $converter=ConverterFactory::getHttpConverter(Config::TEST_API_ADDRESS);
        $converter->convertXML(ExporterFactory::getCSVExporter('testfile.csv',
            RESOURCES_DIR,';'),Config::TEST_API_ITEM_NAME);
        self::assertFileExists(RESOURCES_DIR.'/testfile.csv');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unlink(RESOURCES_DIR.'/testfile.csv');
    }
}
