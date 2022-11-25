<?php

namespace App\Importers;

use App\Connections\FtpConnection;
use App\Converters\FtpConverter;
use Exception;

class FtpImporter extends FileImporter
{

    public function __construct(string $fileName, string $dir, private FtpConnection $connection)
    {
        parent::__construct($fileName,$dir);
        $this->fileName = $fileName;
        $this->dir = $dir;
    }

    protected function prepareFile()
    {
        $conn_id = $this->connection->getConnection();
        if (ftp_get($conn_id, RESOURCES_DIR.'/'.FtpConverter::TEMPORARY_FILENAME, $this->dir.'/'.$this->fileName, FTP_BINARY)) {
           // log success copied file
        }
        else {
            throw new Exception('Problem occured during downloading file to local system.');
            //log failed
        }

        ftp_close($conn_id);

        $this->fileDir=RESOURCES_DIR . '/' . FtpConverter::TEMPORARY_FILENAME;
        if (!file_exists($this->fileDir)) {
            throw new Exception('File not found.');
        }
    }
}