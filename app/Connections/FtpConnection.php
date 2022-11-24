<?php

namespace App\Connections;

use Exception;

class FtpConnection extends Connection
{

    protected function connect()
    {
        $this->conn = ftp_connect($this->address);

        if(!$this->conn){
            throw new Exception('Failed to connect to ftp server');
        }

        $login_result = ftp_login($this->conn, $this->username, $this->password);
        if(!$login_result){
            throw new Exception('Connections credentials invalid');
        }

        return $this->conn;
    }
}