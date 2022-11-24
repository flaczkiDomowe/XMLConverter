<?php

namespace App\Commands;

use App\Factories\ConverterFactory;
use App\Factories\ExporterFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ImportXML extends Command
{

    public function configure()
    {
        $this->setName('import-xml')
            ->setDescription('Imports XML data from local file, remote ftp or http')
            ->setHelp('This will be set later')
            ->addOption('origin','o',InputOption::VALUE_REQUIRED,'Sets origin - either local, ftp or http')
            ->addOption('destination','d',InputOption::VALUE_REQUIRED,'Sets destiny - sqlite or csv. Program will save output in csv file by default.')
            ->addOption('path','p',InputOption::VALUE_REQUIRED,'Sets input path to file if origin\'s local or ftp. 
            If not specified, program will look in default directory (locally in resource folder)')
            ->addOption('filename','f',InputOption::VALUE_REQUIRED,'Sets input filename if origin\'s local or ftp')
            ->addOption('path-output','po',InputOption::VALUE_REQUIRED,'Sets output path to file')
            ->addOption('filename-output','fo',InputOption::VALUE_REQUIRED,'Sets output filename')
            ->addOption('separator','s',InputOption::VALUE_REQUIRED,'Sets separator')
            ->addOption('item-name','i',InputOption::VALUE_REQUIRED,'You need to select name of xml element you wish to get');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $origin = $input->getOption('origin');
        $destination =  $input->getOption('destination');
        $itemName = $input->getOption('item-name');
        if(!$itemName){
            $helper=$this->getHelper('question');
            $question = new Question('Please enter the name of type elements you wish to import: ');
            $itemName = $helper->ask($input, $output, $question);
            if(!$itemName){
                die('Element name not specified');
            }
        }
        $converter=null;
        switch($origin){
            case 'ftp':
                break;
            case 'http':
                break;
            case 'local':
            default:
                $inputFilename = $input->getOption('filename');
                if(!$inputFilename){
                    die("Element name not specified");
                }
                $path = $input->getOption('path') ?? RESOURCES_DIR;
                $converter = ConverterFactory::getLocalFileConverter($inputFilename,$path);
                break;
        }

        $exporter = null;

        switch($destination){
            case 'sqlite':
                break;
            case 'csv':
            default:
                $outputFileName = $input->getOption('filename-output') ?? ExporterFactory::DEFAULT_NAME;
                $outputPath = $input->getOption('path-output') ?? RESOURCES_DIR;
                $separator = $input->getOption('separator') ?? ExporterFactory::DEFAULT_SEPARATOR;
                $exporter = ExporterFactory::getCSVExporter($outputFileName,$outputPath,$separator);
                break;
        }

        $converter->convertXML($exporter,$itemName);


        return Command::SUCCESS;

    }
}