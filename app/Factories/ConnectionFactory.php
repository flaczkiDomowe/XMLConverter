<?php

namespace App\Factories;

use App\Connections\FtpConnection;
use App\Connections\SQLiteConnection;
use Exception;

class ConnectionFactory
{
    public static function getFtpConnection(string $address,string $username, string $password){

        try {
            $ftpConn = new FtpConnection($address, $username, $password);
        } catch (Exception $e){
            error_log($e->getMessage());
            die($e->getMessage());
        }
        return $ftpConn;

    }

    public static function getSQLiteConnection(){
        try {
            $sqlConn = new SQLiteConnection();
        } catch (Exception $e){
            error_log($e->getMessage());
            die($e->getMessage());
        }
        return $sqlConn;
    }

}