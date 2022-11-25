<?php

namespace App\Commands;

use App\Factories\ConnectionFactory;
use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Fetch10Command extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = $input->getArgument('tablename');
        $connection = ConnectionFactory::getSQLiteConnection();
        $results = $connection->getConnection()->query('SELECT * FROM '.$table. "LIMIT 10");
        while(  $row = $results->fetch(PDO::FETCH_ASSOC)){
            foreach($row as $val){
                echo $val.PHP_EOL;
            }
        }
        return Command::SUCCESS;
    }
    public function configure(){
        $this->setName('fetch-sql')
            ->addArgument('tablename',InputArgument::REQUIRED);
    }
}