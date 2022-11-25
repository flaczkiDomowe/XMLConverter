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

    private function getInformation(InputInterface $i, OutputInterface $o,string $message):string
    {
        $helper = $this->getHelper('question');
        $question = new Question($message);
        return $helper->ask($i, $o, $question);
    }

    private function getFtpCredentials(InputInterface $input, OutputInterface $output):array{

        $address = $input->getOption('ftp_host');
        $address = $address ?? $this->getInformation($input,$output,'Enter host address: ');

        $username = $input->getOption('ftp_username');
        $username = $username ?? $this->getInformation($input,$output,'Enter ftp username: ');

        $password = $input->getOption('ftp_password');
        $password = $password ?? $this->getInformation($input,$output,'Please enter ftp password: ');

        return ['address' => $address,'username' => $username, 'password' => $password];
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $origin = $input->getOption('origin');
        $destination = $input->getOption('destination');
        $itemName = $input->getOption('item_name');

        $itemName = $itemName ?? $this->getInformation($input,$output,'Please enter the name of type elements you wish to import: ');
        if(!$itemName){
            die('Element name not specified');
        }
        $converter=null;
        switch($origin){
            case 'ftp':

                $inputFilename = $input->getOption('filename');
                $inputFilename = $inputFilename ?? $this->getInformation($input,$output,'Please enter the name of input file: ');
                if (!$inputFilename) {
                    die("File name not specified");
                }

                $path = $input->getOption('path') ?? '.';
                $credentials = $this->getFtpCredentials($input,$output);
                $converter = ConverterFactory::getFtpConverter($inputFilename, $path, $credentials['address'], $credentials['username'], $credentials['password']);

                break;
            case 'http':

                $url = $input->getOption('url');
                $url = $url ?? $this->getInformation($input,$output,'Please enter xml api url: ');
                if(!$url){
                    die('Url not specified');
                }
                $converter = ConverterFactory::getHttpConverter($url);

                break;
            case 'local':
            default:
                $inputFilename = $input->getOption('filename');
                $inputFilename = $inputFilename ?? $this->getInformation($input,$output,'Please enter the name of input file: ');
                if (!$inputFilename) {
                    die("File name not specified");
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

        echo "Import finished successfully";
        return Command::SUCCESS;

    }
}