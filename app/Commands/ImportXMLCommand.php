<?php

namespace App\Commands;

use App\Factories\ConverterFactory;
use App\Factories\ExporterFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ImportXMLCommand extends Command
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
            ->addOption('path_output',null,InputOption::VALUE_REQUIRED,'Sets output path to file')
            ->addOption('filename_output',null,InputOption::VALUE_REQUIRED,'Sets output filename')
            ->addOption('separator','s',InputOption::VALUE_REQUIRED,'Sets separator')
            ->addOption('ftp_host',null,InputOption::VALUE_REQUIRED,'Sets ftp host')
            ->addOption('ftp_username',null,InputOption::VALUE_REQUIRED,'Sets ftp username')
            ->addOption('ftp_password',null,InputOption::VALUE_REQUIRED,'Sets ftp password')
            ->addOption('url','u',InputOption::VALUE_REQUIRED,'Sets origin url')
            ->addOption('item_name','i',InputOption::VALUE_REQUIRED,'You need to select name of xml element you wish to get');
    }

    private function getFtpCredentials(InputInterface $input, OutputInterface $output):array{

        $address = $input->getOption('ftp_host');
        if(!$address) {
            $helper = $this->getHelper('question');
            $question = new Question('Please enter ftp server address: ');
            $address = $helper->ask($input, $output, $question);
        }

        $username = $input->getOption('ftp_username');
        if(!$username) {
            $helper = $this->getHelper('question');
            $question = new Question('Please enter ftp username: ');
            $username = $helper->ask($input, $output, $question);
        }

        $password = $input->getOption('ftp_password');
        if(!$password) {
            $helper = $this->getHelper('question');
            $question = new Question('Please enter ftp password: ');
            $password = $helper->ask($input, $output, $question);
        }
        return ['address' => $address,'username' => $username, 'password' => $password];
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $origin = $input->getOption('origin');
        $destination =  $input->getOption('destination');
        $itemName = $input->getOption('item_name');

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

                $inputFilename = $input->getOption('filename');
                if(!$inputFilename) {
                    $helper = $this->getHelper('question');
                    $question = new Question('Please enter the name of file: ');
                    $inputFilename = $helper->ask($input, $output, $question);
                    if (!$inputFilename) {
                        die("File name not specified");
                    }
                }
                $path = $input->getOption('path') ?? '.';
                $credentials = $this->getFtpCredentials($input,$output);
                $converter = ConverterFactory::getFtpConverter($inputFilename, $path, $credentials['address'], $credentials['username'], $credentials['password']);

                break;
            case 'http':

                $url = $input->getOption('url');
                if(!$url){
                    $helper=$this->getHelper('question');
                    $question = new Question('Please enter xml api url: ');
                    $url = $helper->ask($input, $output, $question);
                    if(!$url){
                        die('Url not specified');
                    }
                }
                $converter = ConverterFactory::getHttpConverter($url);

                break;
            case 'local':
            default:
                $inputFilename = $input->getOption('filename');
                if(!$inputFilename){
                    die("Element file not specified");
                }
                $path = $input->getOption('path') ?? RESOURCES_DIR;
                $converter = ConverterFactory::getLocalFileConverter($inputFilename,$path);
                break;
        }

        $exporter = null;

        switch($destination){
            case 'sqlite':
                $exporter = ExporterFactory::getSqliteExporter($itemName);
                break;
            case 'csv':
            default:
                $outputFileName = $input->getOption('filename_output') ?? ExporterFactory::DEFAULT_NAME;
                $outputPath = $input->getOption('path_output') ?? RESOURCES_DIR;
                $separator = $input->getOption('separator') ?? ExporterFactory::DEFAULT_SEPARATOR;
                $exporter = ExporterFactory::getCSVExporter($outputFileName,$outputPath,$separator);
                break;
        }

        $converter->convertXML($exporter,$itemName);


        return Command::SUCCESS;

    }
}